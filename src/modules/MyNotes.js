import axios from "axios";

class MyNotes{
    constructor(editId,deleteID) {
        this.editEl = document.querySelectorAll(editId)
        this.deleteEl = document.querySelectorAll(deleteID)

        this.events()
    }

    events = () => {
        this.deleteEl.forEach((el) => {
            el.addEventListener('click', this.deleteNote)
        })
    }

    deleteNote = async (e) => {
        const noteEl = e.target.closest('li')
        if (!noteEl){
            console.error("❌ No parent <li> found!")
            return
        }

        const noteId = noteEl.getAttribute('data-id')
        if (!noteId) {
            console.error(noteId)
            return
        }

        try {
            const response  = await axios.delete(`http://fictional-university.local/wp-json/wp/v2/notebook/${noteId}`, {
                headers : {
                    'X-WP-Nonce': window.wpApiSettings.nonce,
                    'Content-Type': 'Application/json'
                }
            })

            noteEl.remove()
        } catch (e){
            console.log(e.message)
        }
    }
}

export default MyNotes