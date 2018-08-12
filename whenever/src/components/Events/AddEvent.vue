<template>
    <div>
        <form>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <h1>Add an Event</h1>
                    <hr>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Event Name" v-model="title">
                    </div>
                    <div class="form-group">
                        <label for="location">Where</label>
                        <input type="text" id="location" class="form-control" placeholder="Choose location" @keydown="placeSearch" v-model="location">
                    </div>
                    <div class="form-group">
                        <label for="company">Company name</label>
                        <input type="text" id="company" class="form-control" placeholder="Who?" v-model="company">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="date">
                            Select Date From:
                            <input type="date" id="date" v-model="dateFrom">
                            To:
                            <input type="date" id="date" v-model="dateTo">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 from-group">
                    <label for="cat">Category</label>
                    <select id="cat" class="form-control" v-model="selectCat">
                        <option disabled value="">Please select one</option>
                        <option v-for="item in cat" :key="item">
                            {{ item }}</option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 form-group">
                    <label for="desc">Description</label>
                    <br>
                    <textarea id="desc" rows="5" class="form-control" placeholder="Decribe Your Event" v-model="desc"></textarea>
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 form-group">
                    <label>Add picture url</label>
                    <input type="text" id="picSrc" class="form-control" placeholder="add pic src" v-model="picSrc">
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
            <div class="col-xs-12">
                <div class="card card-default">
                    <div class="card-heading">
                        <h4>Your Event</h4>
                    </div>
                    <div class="card-body">
                        <p>Title: {{ title }}</p>
                        <p>Where: {{ location }}</p>
                        <p>Company name: {{ company }}</p>
                        <hr>
                        <p>Category: {{ selectCat }}</p>
                        <p>Date: {{ date }}</p>
                        <hr>
                        <p class="desc" style="white-space: pre">Description:
                            <br>{{ desc }}</p>
                        <hr>
                        <p>Picture:</p>
                        <img :src="picSrc" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                title: '',
                location: '',
                company: '',
                desc: '',
                date: '',
                cat: [
                    'Sport', 'Food', 'Music', 'IT', 'Party'
                ],
                selectCat: '',
                picSrc: 'https://www.w3schools.com/images/w3schools_green.jpg'
            }
        },
        // computed: {
        //     date(){
        //         this.date = dateFrom + dateTo
        //     }
        // },
        methods: {
            onSubmit() {
                const formData = {
                    title: this.title,
                    location: this.location,
                    company: this.company,
                    date: this.date,
                    cat: this.selectCat,
                    desc: this.desc,
                    pic: this.picSrc
                }
                axios.post('https://whenever-b225d.firebaseio.com/event.json', formData)
                    .then((res) => {
                        this.$router.push('/events')
                        alert('Event Saved!')
                    })
                    .catch((err) => console.log(err))
                localStorage.clear();
            },
            placeSearch() {
                var input = document.getElementById('location');
                var autocomplete = new google.maps.places.Autocomplete(input);
            }
        },
        mounted() {
            if (localStorage.title) {
                this.title = localStorage.title;
            }
            if (localStorage.location) {
                this.location = localStorage.location;
            }
            if (localStorage.company) {
                this.company = localStorage.company;
            }
            if (localStorage.date) {
                this.date = localStorage.date;
            }
            if (localStorage.cat) {
                this.cat = localStorage.cat;
            }
            if (localStorage.desc) {
                this.desc = localStorage.desc;
            }
            if (localStorage.pic) {
                this.pic = localStorage.pic;
            }
        },
        watch: {
            title(newName) {
                localStorage.title = newName;
            },
            location(newName) {
                localStorage.location = newName;
            },
            company(newName) {
                localStorage.company = newName;
            },
            date(newName) {
                localStorage.date = newName;
            },
            cat(newName) {
                localStorage.cat = newName;
            },
            desc(newName) {
                localStorage.desc = newName;
            },
            pic(newName) {
                localStorage.pic = newName;
            }
        },
    }
</script>

<style>
    p {
        width: 1fr
    }
</style>