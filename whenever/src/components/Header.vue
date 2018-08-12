<template>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <a class="navbar-brand" href="#">whenever.</a>
            <button class="navbar-toggler" type="button" @click="isCollapsed = !isCollapsed">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div :class="{collapse: isCollapsed}" class=" navbar-collapse">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <!-- <router-link to="/home" tag="li">
                        <a class="nav-link">
                            Home</a>
                    </router-link> -->
                    <router-link to="/events" tag="li">
                        <a class="nav-link">
                            All Events</a>
                    </router-link>
                    <router-link to="/addEvent" tag="li">
                        <a class="nav-link">
                            New Event</a>
                    </router-link>
                    <router-link to="/myPanel" tag="li">
                        <a class="nav-link">
                            My Panel</a>
                    </router-link>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>

        </nav>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isCollapsed: true
            }
        }
    }
</script>