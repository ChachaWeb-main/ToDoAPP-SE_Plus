<template>
    <div class="container-fruid" style="overflow-y: scroll;">

        <div class="modal fade" :id="'todoModal'+goalId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Todo Content</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="content" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="addNewTodo">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-for="(todo, key, index) in todos" :key=index>
            <div class="d-flex justify-content-center m-3">
                <div class="card" style="width: 18rem;" v-if="todo.done == 0">
                    <div class="card-body">
                        <h5 class="card-title">{{todo.content}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{todo.created_at}}</h6>
                    </div>
                    <div class="btn-group position-absolute dropdown" style="top:10px; right:4px;">
                        <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="text-center text-success" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 0">Done</div>
                            <div class="text-center" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 1">Not Done</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoModal'+goalId+todo.id" v-on:click="content = todo.content">Edit</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoSortModal'+goalId+todo.id" v-on:click="content = todo.content">Sort</div>
                            <div class="text-center text-danger" v-on:click="deleteTodo(todo)">Delete</div>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 18rem;" v-if="todo.done == 1">
                    <div class="card-body">
                        <h5 class="card-title"><s>{{todo.content}}</s></h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{todo.created_at}}</h6>
                    </div>
                    <div class="btn-group position-absolute dropdown" style="top:10px; right:4px;">
                        <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="text-center text-success" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 0">Done</div>
                            <div class="text-center" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 1">Not Done</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoModal'+goalId+todo.id" v-on:click="content = todo.content">Edit</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoSortModal'+goalId+todo.id" v-on:click="content = todo.content">Sort</div>
                            <div class="text-center text-danger" v-on:click="deleteTodo(todo)">Delete</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" :id="'todoModal'+goalId+todo.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Todo Content</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <input v-model="content" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="editTodoContent(todo)">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" :id="'todoSortModal'+goalId+todo.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sort Todo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <select class="form-control" id="exampleFormControlSelect1" v-model="sort_id">
                                <option v-for="(todo, key, index) in todos" :key=index>
                                    {{ key + 1 }}
                                </option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="sortTodo(todo)">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios"
import $ from "jquery"
export default {
    props: ['goalId'],
    data: function() {
        return {
            id: "",
            content: "",
            todos: [],
            sort_id: ""
        }
    },
    mounted: function () {
        this.getAllTodos();
    },
    methods: {
        getAllTodos: function () {
            axios.get(`/goals/${this.goalId}/todos`).then((response) => {
                console.log(response)
                for(let i = 0; i < response.data.length; i++) {
                    this.todos.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
        },
        addNewTodo: function () {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${this.goalId}/todos`, {content: this.content, position: this.todos.length}).then((response) => {
                this.todos.length = 0;
                for (let i = 0; i < response.data.length; i++) {
                    this.todos.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
            this.content = ""
        },
        doneTodoUpdate: function (todo) {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            let done = todo.done == 0 ? true : false;
            axios.post(`/goals/${this.goalId}/todos/${todo.id}`, {content: todo.content, position: todo.position, done: done, _method: "patch"}).then((response) => {
                this.todos.length = 0;
                console.log(response)
                for (let i = 0; i < response.data.length; i++) {
                    this.todos.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
            this.content = ""
        },
        editTodoContent: function (todo) {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${todo.goal_id}/todos/${todo.id}`, {content: this.content, position: todo.position, done: todo.done, _method: "patch"}).then((response) => {
                this.todos.length = 0;
                console.log(response)
                for (let i = 0; i < response.data.length; i++) {
                    this.todos.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
            this.content = ""
        },
        deleteTodo: function (todo) {
            if(confirm("Delete?")) {
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                axios.post(`/goals/${this.goalId}/todos/${todo.id}`, {_method: "delete"}).then((response) => {
                    this.todos = response.data;
                }, (error) => {
                    console.log(error)
                })
            }
        },
        sortTodo: function (todo) {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            console.log(this.sort_id)
            axios.post(`/goals/${this.goalId}/todos/${todo.id}/sort`, {sortId: this.sort_id - 1}).then((response) => {
                this.todos.length = 0;
                console.log(response)
                for (let i = 0; i < response.data.length; i++) {
                    this.todos.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
        },        
    }
}
</script>