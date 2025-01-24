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
            const response = await axios.get('/wp-json/wp/v2/posts', {
                params: {
                    search : e.target.value
                }
            })
            const posts = response.data

            if (posts.length < 1){
                this.searchResult.innerHTML = "No data found"
            }

            if (posts.length > 0){
                this.searchResult.innerHTML = `
                    <h2 class="search-overlay__section-title">General Information</h2>
                    <ul class="link-list min-list">
                        ${posts.map(post => this.getSingleResultHTML(post)).join('')}
                    </ul>
                `
            }
        } catch (err) {
            console.error('Error: ', err.message)
            this.searchResult.innerHTML = this.err.message
        } finally {
            this.isLoading = false
        }
    }

    getSingleResultHTML = (post) => {
        return `
            <li>
                <a href="${post.link}"> ${post.title?.rendered} </a>
            </li>
        `
    }
}

export default Search