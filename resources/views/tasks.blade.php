

<body>
@extends('layouts.app')
  
@section('title') My Notes @endsection

@section('content')
    <div id="app">
        <h1>Tasks</h1>
        @verbatim
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
            @endverbatim
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
                        if (data.length > 0) {
                            this.tasks = data;
                        }
                        else {
                            this.tasks = [];
                        }
                    });
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
    @endsection
</body>

</html>


                       
