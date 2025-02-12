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

        this.editEl.forEach((el) => {
            el.addEventListener('click', this.editNote)
        })
    }

    editNote = async (e) => {
        const noteEl = e.target.closest('li')
        const isEditable = noteEl.getAttribute('data-state') === 'editable'

        this.toggleNoteState(e,noteEl,isEditable)
    }

    toggleNoteState = (e,noteEl,isEditable) => {
        const title = noteEl.querySelector('.note-title-field')
        const body = noteEl.querySelector('.note-body-field')
        const updateButton = document.querySelector('.update-note')
        const editButton = e.target.closest('.edit-note')

        if (!isEditable) {
            editButton.innerHTML = `<i class="fa fa-times" aria-hidden="true"></i> Cancel`
            updateButton.classList.add('update-note--visible')

            title.removeAttribute('readonly')
            body.removeAttribute('readonly')

            title.classList.add('note-active-field')
            body.classList.add('note-active-field')

            title.focus()
            title.setSelectionRange(title.value.length, title.value.length)

            noteEl.setAttribute('data-state', 'editable')
        }

        if (isEditable){
            updateButton.classList.remove('update-note--visible')
            editButton.innerHTML = `<i class="fa fa-pencil" aria-hidden="true"></i> Edit`

            title.setAttribute('readonly', 'true');
            body.setAttribute('readonly', 'true');

            title.classList.remove('note-active-field')
            body.classList.remove('note-active-field')

            noteEl.setAttribute('data-state', ' ')
        }
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