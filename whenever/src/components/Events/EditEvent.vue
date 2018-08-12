<template>
    <div class="container">
        <form>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <h1>Edit an Event</h1>
                    <hr>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" class="form-control"  v-model="event.title">
                    </div>
                    <div class="form-group">
                        <label for="location">Where</label>
                        <input type="text" id="location" class="form-control" @keydown="placeSearch" v-model="event.location">
                    </div>
                    <div class="form-group">
                        <label for="company">Company name</label>
                        <input type="text" id="company" class="form-control" v-model="event.company">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="date">
                            Select Date
                            <input type="date" id="date" v-model="event.date">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 from-group">
                    <label for="cat">Category</label>
                    <select id="cat" class="form-control" v-model="event.selectCat">
                        <option disabled value="">Please select one</option>
                        <option v-for="item in event.cat" :key="item">
                            {{ item }}</option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 form-group">
                    <label for="desc">Description</label>
                    <br>
                    <textarea id="desc" rows="5" class="form-control" v-model="event.desc"></textarea>
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 form-group">
                    <label>Add picture url</label>
                    <input type="text" id="picSrc" class="form-control" v-model="event.pic">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <button @click.prevent="onSubmit" class="btn btn-primary">Submit!
                    </button>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Your Event</h4>
                    </div>
                    <div class="card-body">
                        <p>Title: {{ event.title }}</p>
                        <p>Where: {{ event.location }}</p>
                        <p>Company name: {{ event.company }}</p>
                        <hr>
                        <p>Category: {{ event.selectCat }}</p>
                        <p>Date: {{ event.date }}</p>
                        <hr>
                        <p style="white-space: pre">Description:
                            <br>{{ event.desc }}</p>
                        <hr>
                        <p>Picture:</p>
                        <img :src="event.pic" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        data() {
            return {
                event: ""
            };
        },
        methods: {
            placeSearch() {
                var input = document.getElementById('location');
                var autocomplete = new google.maps.places.Autocomplete(input);
            }
        },  
        created() {
            axios
                .get("https://whenever-b225d.firebaseio.com/event.json")
                .then(res => {
                    const eventId = this.$route.query.id;
                    this.event = res.data[eventId]
                })
                .catch(err => console.log(err));
        }
    };
</script>

<style>
</style>