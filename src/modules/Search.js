class Search{
    constructor(searchTriggerId, closeTriggerId, refId, inputId) {
        this.searchTrigger = document.getElementById(searchTriggerId)
        this.closeTrigger = document.getElementById(closeTriggerId)
        this.ref = document.getElementById(refId)
        this.input = document.getElementById(inputId)

        this.isOverlayOpen = false

        this.events()
    }

    events(){
        this.searchTrigger.addEventListener('click', this.openOverlay)
        this.closeTrigger.addEventListener('click', this.closeOverlay)

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
    }

    keyPressDispatcher = (e)=>{
        if (e.key === 's' && !this.isOverlayOpen){
            this.openOverlay()
        }

        if (e.key === 'Escape' && this.isOverlayOpen){
            this.closeOverlay()
        }
    }
}

export default Search