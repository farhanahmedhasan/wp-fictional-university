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
            const pageLinks = response.data.view_all_post_type_links

            const isEmpty = Object.keys(data).every(key => data[key].length === 0)

            if (isEmpty){
                this.searchResult.innerHTML = `
                    <h2 class="search-overlay__section-title">Information</h2>
                    <p>No information that matches our search.</p>
                `
            }

            if (!isEmpty){
                this.searchResult.innerHTML = `
                    <div class="row">
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">General Information</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'generalInfo',pageLinks)}
                        </div>
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">Programs</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'program',pageLinks)}
                            
                            <h2 class="search-overlay__section-title">Professors</h2>
                            ${data.professor.length < 1 ? `<p>No Professors Found.</p>`: ''}
                            <ul class="professor-cards">
                                ${data.professor.map(item => 
                                    `
                                    <li class="professor-card__list-item">
                                        <a class="professor-card" href=${item.link}>
                                            <img class="professor-card__image" src=${item.thumbnail} alt="">
                                            <span class="professor-card__name">${item.title}</span>
                                        </a>
                                    </li>
                                    `
                                ).join('')}
                            </ul>
                        </div>
                        <div class="one-third">
                            <h2 class="search-overlay__section-title">Campuses</h2>
                            ${this.getSinglePostTypeResultsIfExists(data,'campus',pageLinks)}
                            
                            <h2 class="search-overlay__section-title">Events</h2>
                            ${data.event.length < 1 ? `<p>No Events Found. View all <a href="${pageLinks.event}">Events</a></p>`: ''}
                            ${data.event.map(item =>
                            `
                                <div class="event-summary">
                                    <a class="event-summary__date t-center" href="${item.link}">
                                        <span class="event-summary__month">${item.upcoming_event_time.event_month}</span>
                                        <span class="event-summary__day">${item.upcoming_event_time.event_day}</span>
                                    </a>
                                    <div class="event-summary__content">
                                        <h5 class="event-summary__title headline headline--tiny">
                                            <a href=${item.link}>${item.title}</a>
                                        </h5>
                                        <p>
                                            ${item.excerpt}
                                            <a href=${item.link} class="nu gray">Learn more</a>
                                        </p>
                                    </div>
                                </div>
                            `
                            ).join('')}
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

    getSinglePostTypeResultsIfExists = (data,postType,pageLinks) => {
        const link = pageLinks[postType] ? `view all <a href=${pageLinks[postType]}>${postType}</a>` : ''

        return data[postType].length > 0 ?
            data[postType].map(item=> this.getSingleResultHTML(item)).join('')
            : `<p>No data found. ${link}</p>`
    }

    getSingleResultHTML = (item) => {
        const string = item.post_type === "post" ? " by " + item.author_name : ""

        return `
            <li>
                <a href="${item.link}"> ${item.title}</a>
                ${string}
            </li>
        `
    }
}

export default Search