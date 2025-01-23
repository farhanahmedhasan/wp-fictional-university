class Search{
    searchTrigger = ""
    closeTrigger = ""
    ref = ""

    constructor(searchTriggerId, closeTriggerId, refId) {
        this.searchTrigger = document.getElementById(searchTriggerId)
        this.closeTrigger = document.getElementById(closeTriggerId)
        this.ref = document.getElementById(refId)
    }

    onTogglSearch() {
        this.searchTrigger.addEventListener('click', ()=> {
            this.ref.classList.add('search-overlay--active')
        })

        this.closeTrigger.addEventListener('click', ()=> {
            this.ref.classList.remove('search-overlay--active')
        })
    }
}

export default Search