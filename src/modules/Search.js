class Search{
    constructor(searchTriggerId, closeTriggerId, refId) {
        this.searchTrigger = document.getElementById(searchTriggerId)
        this.closeTrigger = document.getElementById(closeTriggerId)
        this.ref = document.getElementById(refId)

        this.events()
    }

    events(){
        this.searchTrigger.addEventListener('click', this.openOverlay)
        this.closeTrigger.addEventListener('click', this.closeOverlay)
    }

    openOverlay = () => {
        this.ref.classList.add('search-overlay--active')
    }

    closeOverlay = ()=> {
        this.ref.classList.remove('search-overlay--active')
    }
}

export default Search