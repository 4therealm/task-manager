

<body>
@extends('layouts.app')
  
@section('title') My Notes @endsection

@section('content')
    <div id="app">
        <h1>Notes</h1>
        @verbatim
        <ul v-if="notes.length">
            <li v-for="note in notes" :key="note.id">
                <input type="checkbox" v-model="note.completed" @change="updateNote(note)">
                <span v-if="!note.completed">@{{ note.title }}</span>
                <span v-else><del>@{{ note.title }}</del></span>
                <button class="btn btn-danger" @click="deleteNote(note)">Delete</button>
            </li>
        </ul>
        <p v-else>No notes to display.</p>

        <div>
            <form @submit.prevent="addNote">
                <input type="text" v-model="newNote.title" placeholder="Note title">
                <textarea v-model="newNote.content" placeholder="Note content"></textarea>
                <button type="submit">Add Note</button>
            </form>
            @endverbatim
        </div>
    </div>

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                notes: [],
                newNote: {
                    title: '',
                    content: '',
                    completed: false
                }
            },
            methods: {
                fetchNotes() {
                    $.ajax({
                        url: 'api/notes',
                        method: 'GET',
                        success: (data) => {
                            this.notes = data;
                        },
                        error: (xhr, status, error) => {
                            console.error(xhr, status, error);
                        }
                    });
                },
                addNote() {
                    $.ajax({
                        url: 'api/notes',
                        method: 'POST',
                        data: this.newNote,
                        success: (data) => {
                            this.notes.push(data);
                            this.newNote = {
                                title: '',
                                content: '',
                                completed: false
                            };
                        },
                        error: (xhr, status, error) => {
                            console.error(xhr, status, error);
                        }
                    });
                },
                updateNote(note) {
                    $.ajax({
                        url: `api/notes/${note.id}`,
                        method: 'PUT',
                        data: note,
                        success: (data) => {
                            const index = this.notes.findIndex(note => note.id === note.id);
                            this.notes.splice(index, 1, data);
                        },
                        error: (xhr, status, error) => {
                            console.error(xhr, status, error);
                        }
                    });
                },
                deleteNote(note) {
                    $.ajax({
                        method: 'DELETE',
                        url: `/api/notes/${note.id}`,
                        success: (data) => {
                            const index = this.notes.findIndex(n => n.id === note.id);
                            this.notes.splice(index, 1);
                        }
                    });


}
            },
            mounted() {
                this.fetchNotes();
            }
        });
      
    </script>
    @endsection
</body>


                       
