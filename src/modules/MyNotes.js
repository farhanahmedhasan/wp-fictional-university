import axios from "axios";

class MyNotes{
    constructor(editId,deleteID) {
        this.editEl = document.querySelectorAll(editId)
        this.deleteEl = document.querySelectorAll(deleteID)
        this.updateNoteEl = document.querySelectorAll('.update-note')

        this.events()
    }

    events = () => {
        this.deleteEl.forEach((el) => {
            el.addEventListener('click', this.deleteNote)
        })

        this.editEl.forEach((el) => {
            el.addEventListener('click', this.editNote)
        })

        this.updateNoteEl.forEach(el => {
            el.addEventListener('click', this.updateNote)
        })
    }

    editNote = (e) => {
        const noteEl = e.target.closest('li')
        const isEditable = noteEl.getAttribute('data-state') === 'editable'

        this.toggleNoteState(noteEl,isEditable)
    }

    updateNote = async (e) => {
        const noteEl = e.target.closest('li')
        const noteId = noteEl.getAttribute('data-id')

        // Key name has to be exact as wp will be looking for these exact names
        const noteData = {
            'title': noteEl.querySelector('.note-title-field').value,
            'content':noteEl.querySelector('.note-body-field').value
        }

        try {
            const response  = await axios.patch(`http://fictional-university.local/wp-json/wp/v2/notebook/${noteId}`, noteData, {
                headers : {
                    'X-WP-Nonce': window.wpApiSettings.nonce,
                    'Content-Type': 'Application/json'
                }
            })
            this.toggleNoteState(noteEl,true)
        } catch (e){
            console.log(e.message)
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

    toggleNoteState = (noteEl,isEditable) => {
        const title = noteEl.querySelector('.note-title-field')
        const body = noteEl.querySelector('.note-body-field')
        const updateButton = noteEl.querySelector('.update-note')
        const editButton = noteEl.querySelector('.edit-note')

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
}

export default MyNotes