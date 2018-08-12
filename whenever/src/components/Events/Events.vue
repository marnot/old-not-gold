<template v-if="viewAll">
  <div class="container ">
    <div class="row">
      <div v-for="(event, key) in events" :key="key" class="col-lg-4">
        <router-link :to="{ path: '/event', query: { id: key }}" tag="div">
            <img class="card-img-top" src= "../../assets/image2.png" alt="">
            <div class="card card-body">
              <h5 class="card-title ellipsis">{{ event.title }}</h5>
              <p class="card-text tran">{{ event.desc }}</p>
              <p :class="{collapse: isCollapsed}" class="date">{{ event.date }}</p>
              <p class="ellipsis">{{ event.location }}</p>
              <p class="ellipsis">{{ event.company }}</p>
          </div>
         </router-link>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    data() {
      return {
        events: ""
      };
    },
    created() {
      axios
        .get("https://whenever-b225d.firebaseio.com/event.json")
        .then(res => {
          this.events = res.data;
        })
        .catch(err => console.log(err));
        localStorage.data = this.events
    }
  };
</script>


<style>
.tran {
  /* hide text if it more than N lines  */
  overflow: hidden;
  /* for set '...' in absolute position */
  position: relative; 
  /* use this value to count block height */
  line-height: 1.2em;
  /* max-height = line-height (1.2) * lines max number (3) */
  max-height: 3.6em; 
  /* fix problem when last visible word doesn't adjoin right side  */
  text-align: justify;  
  /* place for '...' */
  margin-right: -1em;
  padding-right: 1em;
}
/* create the ... */
.tran:before {
  /* points in the end */
  content: '...';
  /* absolute position */
  position: absolute;
  /* set position to right bottom corner of block */
  right: 0;
  bottom: 0;
}
/* hide ... if we have text, which is less than or equal to max lines */
.tran:after {
  /* points in the end */
  content: '';
  /* absolute position */
  position: absolute;
  /* set position to right bottom corner of text */
  right: 0;
  /* set width and height */
  width: 1em;
  height: 1em;
  margin-top: 0.2em;
  /* bg color = bg color under block */
  background: white;
}

.ellipsis {
  overflow:hidden; 
  white-space: nowrap;
  text-overflow: ellipsis;
}

/* .text-bt{
  position: ;
} */
</style>
