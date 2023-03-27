

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notes</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>
    <div id="app">
        <h1>Notes</h1>
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
                    fetch('api/notes')
                        .then(response => response.json())
                        .then(notes => this.notes = notes);
                },
                addNote() {
                    fetch('api/notes', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.newNote)
                    })
                        .then(response => response.json())
                        .then(note => {
                            this.notes.push(note);
                            this.newNote = {
                                title: '',
                                content: ''
                            };
                        });
                },
                updateNote(note) {
                    fetch(`api/notes/${note.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(note)
                    })
                        .then(response => response.json())
                        .then(note => {
                            const index = this.notes.findIndex(note => note.id === note.id);
                            this.notes.splice(index, 1, note);
                        });
                },
                deleteNote(note) {
                    fetch(`api/notes/${note.id}`, {
                        method: 'DELETE'
                    })
                        .then(response => response.json())
                        .then(note => {
                            const index = this.notes.findIndex(note => note.id === note.id);
                            this.notes.splice(index, 1);
                        });
                }
            },
            mounted() {
                this.fetchNotes();
            }
        });
    </script>