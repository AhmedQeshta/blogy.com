<template>
    <div>
        <navBar/>
        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">title</th>
                            <th scope="col">Time Created</th>
                            <th scope="col">image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(post,index) in allPost.data" v-bind:key="index">
                            <th scope="row">{{ ++index }}</th>
                            <td>{{ post.title }}</td>
                            <td>{{ post.created_at | newFormatDate }}</td>
                            <td class="mx-auto w-50">
                                <img :src="'https://blogy.com.test/' + post.image " alt=""
                                     class="img-fluid w-25 mx-auto">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="this.messageEmpty" class="text-center">
                        <div class="badge badge-info m-2 p-2 ">{{ messageEmpty }}</div>
                    </div>
                </div><!-- End Of col-->
            </div><!-- End Of row-->
        </div><!-- End Of container-->

        <div class="container my-5 text-center mx-auto w-100 d-flex justify-content-center align-items-center">
            <nav aria-label="...">
                <ul class="pagination">
                    <li :class="[{disabled: !allPost.prev_page_url} ]" class="page-item ">
                        <a aria-disabled="true" class="page-link" href="#" tabindex="-1"
                           @click.prevent="fetchPosts(allPost.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page
                        {{ this.numberPage }}/{{ allPost.last_page }}</a></li>
                    <li :class="[{disabled: !allPost.next_page_url} ]" class="page-item">
                        <a class="page-link" href="#" @click.prevent="fetchPosts(allPost.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <Footer/>
    </div>
</template>

<script>
import NavBar from "../components/navBar";
import Footer from "../components/Footer";
import moment from "moment";
import {mapGetters} from "vuex";

export default {
    name: "Welcome",
    components: {Footer, NavBar},
    data() {
        return {
            messageEmpty: null,
            numberPage: 1,
            posts: [],
        }
    },
    methods: {
        fetchPosts(page_url) {
            let numPage = page_url.split('=');
            fetch(page_url)
                .then(response => response.json()).then(response => {
                this.$store.dispatch('allPost', response.allPosts);
                this.numberPage = numPage[1];
            }).catch(error => {
                console.log(error.response.data.message);
            });
        },

    },
    async beforeMount() {
        let res = await axios.get('/api/post/all');
        await this.$store.dispatch('allPost', res.data.allPosts);
        if (res.data.allPosts.data.length === 0) {
            this.messageEmpty = "Sorry!, Not Add Any Posts Yet";
        }
    },
    filters: {
        newFormatDate(value) {
            if (!value) return ''
            value = value.toString()
            if (value) {
                return moment(value).format('DD MMM,YYYY');
            }
        },
    },
    computed: {
        ...mapGetters(['allPost'])
    },
}
</script>

<style scoped>

</style>
