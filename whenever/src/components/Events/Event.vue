<template>
    <div class="jumbotron">
        <div class="card">
            <div v-if="!user" class="card-header col-lg-12">
                <button @click = "deleteEvent" class="btn btn-outline-danger float-right">delete</button>
                <router-link :to="{ path: '/edit', query: { id: eventId }}" tag="div">
                    <a class="btn btn-outline-primary float-right">edit</a>
                </router-link>
            </div>
                <h3 class="card-title ">{{ event.title }}</h3>
                <p>{{ event.cat }}</p>
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{ event.date }}</li>
                <li class="list-group-item">{{ event.location }}</li>
                <li class="list-group-item">{{ event.company }}</li>
            </ul>
            <div class="card-body">
                <p class="text-center" style="padding:20px">{{ event.desc }}</p>

            </div>
        </div>
    </div>
</template>
<script>
    import axios from "axios";

    export default {
        methods:{
            deleteEvent(){
                if(confirm('Sure?')) {
                    firebase.database().ref("event/" + this.eventId).remove();
                    this.$router.push("/events")
                }
            }
        },
        data() {
            return {
                event: '',
                eventId: ''
            }
        },
        created() {
            axios
                .get("https://whenever-b225d.firebaseio.com/event.json")
                .then(res => {
                    const eventId = this.$route.query.id;
                    this.event = res.data[eventId]
                    console.log(this.$route.query.id)
                })
                .catch(err => console.log(err));
            this.eventId = this.$route.query.id;
        }
    };
</script>