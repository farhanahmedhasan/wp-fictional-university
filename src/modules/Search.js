import axios from "axios";

class Search{
    constructor(searchTriggerId, closeTriggerId, refId, inputId, searchResultId) {
        this.searchTrigger = document.getElementById(searchTriggerId)
        this.closeTrigger = document.getElementById(closeTriggerId)
        this.ref = document.getElementById(refId)
        this.input = document.getElementById(inputId)
        this.searchResult = document.getElementById(searchResultId)

        this.isOverlayOpen = false
        this.isLoading = false
        this.typingTimer;
        this.prevValue;

        this.events()
    }

    events(){
        this.searchTrigger.addEventListener('click', this.openOverlay)
        this.closeTrigger.addEventListener('click', this.closeOverlay)

        this.input.addEventListener('keyup', this.searchLogic)
        document.addEventListener('keydown', this.keyPressDispatcher)
    }

    openOverlay = () => {
        this.ref.classList.add('search-overlay--active')
        document.body.classList.add('body-no-scroll')
        this.isOverlayOpen = true

        setTimeout(() => {
            this.input.focus();
        }, 300);
    }

    closeOverlay = ()=> {
        this.ref.classList.remove('search-overlay--active')
        document.body.classList.remove('body-no-scroll')
        this.isOverlayOpen = false
        this.input.value = ""
        this.prevValue = ""
        this.searchResult.innerHTML = ""
    }

    keyPressDispatcher = (e)=> {
        const isInputFocused = document.activeElement instanceof HTMLInputElement || document.activeElement instanceof HTMLTextAreaElement;

        if (e.key === 's' && !this.isOverlayOpen && !isInputFocused){
            this.openOverlay()
        }

        if (e.key === 'Escape' && this.isOverlayOpen){
            this.closeOverlay()
        }
    }

    searchLogic = (e) => {
        if (this.input.value === "") {
            this.searchResult.innerHTML = ""
            return
        }

        const currentValue = e.target.value
        if (currentValue === this.prevValue) return
        this.prevValue = currentValue

        if (!this.isLoading){
            this.searchResult.innerHTML = '<div class="spinner-loader"></div>'
            this.isLoading = true
        }

        clearTimeout(this.typingTimer)
        this.typingTimer = setTimeout(()=> this.getSearchResult(e), 500)
    }

    getSearchResult = async (e) => {
        try {
            const options = {
                params: {
                    keyword : e.target.value,
                    per_page: 2
                }
            }

            const response = await axios.get('/wp-json/university/v1/search', options)
            const data = response.data.results
            console.log(data)

            const isEmpty = Object.keys(data).every(key => data[key].length === 0)

            if (isEmpty){
                this.searchResult.innerHTML = `
                    <h2 class="search-overlay__section-title">General Information</h2>
                    <p>No general information that matches our search.</p>
                `
            }

            if (!isEmpty){
                this.searchResult.innerHTML = `
                    <div class="row">
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">General Information</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'generalInfo')}
                        </div>
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">Programs</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'program')}
                            
                            <h2 class="search-overlay__section-title">Professors</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'professor')}
                        </div>
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">Campuses</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'campus')}
                            
                            <h2 class="search-overlay__section-title">Events</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'event')}
                        </div>
                    </div>
                `
            }
        } catch (err) {
            console.error('Error: ', err.message)
            this.searchResult.innerHTML = "<p>Internal error try again.</p>"
        } finally {
            this.isLoading = false
        }
    }

    getSinglePostTypeResultsIfExists = (data,postType) => data[postType].length > 0 ? data[postType].map(item=> this.getSingleResultHTML(item)).join('') : '<p>No data found</p>'

    getSingleResultHTML = (item) => {
        return `
            <li>
                <a href="${item.link}"> ${item.title}</a>
            </li>
        `
    }
}

export default Search