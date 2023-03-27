<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Manager</title>

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
        <h1>Task Manager</h1>
        <ul v-if="tasks.length">
            <li v-for="task in tasks" :key="task.id">
                <input type="checkbox" v-model="task.completed" @change="updateTask(task)">
                <span v-if="!task.completed">@{{ task.title }}</span>
                <span v-else><del>@{{ task.title }}</del></span>
                <button class="btn btn-danger" @click="deleteTask(task)">Delete</button>
            </li>
        </ul>
        <p v-else>No tasks to display.</p>

        <div>
    <form @submit.prevent="addTask">
        <input type="text" v-model="newTask.title" placeholder="Task title">
        <textarea v-model="newTask.description" placeholder="Task description"></textarea>
        <label for="completed">Completed:</label>
        <input type="checkbox" id="completed" v-model="newTask.completed">
        <button type="submit">Add Task</button>
    </form>
</div>

    </div>
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                tasks: [],
                newTask: {
                    title: '',
                    description: '',
                    completed: false
                }
            },
            methods: {
                fetchTasks() {
                    $.getJSON('/api/tasks', (data) => {
                      .then(response => response.json())
                        .then(notes => this.tasks = tasks);
                },
                addTask() {
    // Set the completed field to a boolean value
    this.newTask.completed = (this.newTask.completed === 'true');
    
    $.ajax({
        method: 'POST',
        url: '/api/tasks',
        data: this.newTask,
        success: (data) => {
            this.tasks.push(data);
            this.newTask = {
                title: '',
                description: '',
                completed: true
            }
        }
    });
},

                updateTask(task) {
                    $.ajax({
                        method: 'PUT',
                        url: `/api/tasks/${task.id}`,
                        data: task,
                        success: (data) => {
                            console.log("🚀 ~ file: welcome.blade.php:64 ~ $.ajax ~ data", data)
                        }
                    });
                },
                deleteTask(task) {
                    $.ajax({
                        method: 'DELETE',
                        url: `/api/tasks/${task.id}`,
                        success: (data) => {
                            this.tasks = this.tasks.filter((t) => t.id !== task.id);
                        }
                    });
                }
            },
            mounted() {
                this.fetchTasks();
            }
        });
    </script>

 

</body>
</html>
