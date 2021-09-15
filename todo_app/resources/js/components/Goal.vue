<template>
    <div class="container-fruid h-100 pt-5">
        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#goalModal"></i><span class="align-middle"> Create A New Goal</span>

        <div class="modal fade" id="goalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Goal Name</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="title" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="addNewGoal">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editGoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Goal Name</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="title" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="editGoalTitle">Edit</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteGoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Goal?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="deleteGoal">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-group h-100">
            <div v-for="(goal, key, index) in goals" :key=index>
                <div class="card h-100 m-3" style="width: 24rem;">
                    <div class="d-flex justify-content-between">
                        <h3 class="ml-5 mt-2">{{ goal.title }}</h3>
                        <div>
                            <i class="fa fa-plus p-2" data-toggle="modal" :data-target="'#todoModal'+goal.id"></i>
                            <div class="btn-group dropdown">
                                <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="text-center" data-toggle="modal" data-target="#editGoalModal" v-on:click="title = goal.title; id = goal.id">Edit</div>
                                        <div class="text-danger text-center" data-toggle="modal" data-target="#deleteGoalModal" v-on:click="id = goal.id">Delete</div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <goals-todos :goalId="goal.id"></goals-todos>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
import axios from "axios"
import $ from "jquery"
import Todos from "./Todos.vue";
export default {
    data: function() {
        return {
            id: "",
            title: "",
            goals: []
        }
    },
    components: {
        'goals-todos': Todos
    },
    mounted: function () {
        this.getAllGaols();
    },
    methods: {
        getAllGaols: function () {
            axios.get("/goals").then((response) => {
                for(let i = 0; i < response.data.length; i++) {
                    this.goals.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
        },
        addNewGoal: function () {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post("/goals", {title: this.title}).then((response) => {
                this.goals.length = 0;
                for (let i = 0; i < response.data.length; i++) {
                    this.goals.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
            this.title = ""
        },
        editGoalTitle: function () {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${this.id}`, {title: this.title, _method: 'patch'}).then((response) => {
                this.goals.length = 0;
                for (let i = 0; i < response.data.length; i++) {
                    this.goals.push(response.data[i])
                }
            }, (error) => {
                console.log(error)
            })
            this.title = ""
        },
        deleteGoal: function () {
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            console.log(this.id)
            axios.post(`/goals/${this.id}`, {_method: 'delete'}).then((response) => {
                this.goals = response.data;
            }, (error) => {
                console.log(error)
            })
            this.id = ""
        }
    }
}
</script>