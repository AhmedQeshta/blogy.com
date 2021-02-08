<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button aria-controls="navigations-08" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler"
                    data-target="#navigations-08" data-toggle="collapse" type="button"><span
                class="navbar-toggler-icon"></span></button>
            <div id="navigations-08" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link :to="{path:'/admin/dashboard'}" class="nav-link">home</router-link>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Support</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col col-md-12">
                    <div class="card">
                        <div class="card-header">
                            all post
                        </div>
                        <div class="card-body">
                            <div v-for="(post,index) in posts.Posts" v-bind:key="index"
                                 class="bg-info text-white p-3 m-2 rounded-sm">
                                <div class="">
                                    <button class="btn btn-danger btn-sm float-right"
                                            @click.prevent="DeletePost(post.id)">Delete
                                    </button>

                                    <button class="btn btn-dark btn-sm float-right mr-2">
                                        <router-link :to="{path:'/admin/dashboard/update/post/' + post.id }"
                                                     class="text-white">
                                            update
                                        </router-link>
                                    </button>
                                </div>
                                <div class="w-100 mx-auto text-center d-flex justify-content-center align-items-center">
                                    <img v-if="post.image" :alt="post.title"
                                         :src="'https://blogy.com.test/' + post.image "
                                         class="img-fluid w-75 mt-2 mb-2 mx-auto text-center">
                                </div>
                                <div>
                                    <h2 class="ti">{{ post.title }}</h2>
                                    <p>{{ post.body }}</p>
                                    <p class="badge badge-dark"> {{ post.created_at | newFormatDate }}</p>
                                </div>
                            </div>
                            <div v-if="posts.error" class="align-items-center alert alert-danger ">
                                Error
                            </div>
                            <div v-if="posts.length === 0" class="align-items-center alert alert-info ">
                                not Add post yet
                            </div>
                            <div v-if="messageEmpty" class="bg-dark text-white p-3 text-center rounded-sm">
                                {{ messageEmpty }}
                            </div>
                        </div>
                    </div>

                </div><!-- End Of col-->
            </div><!-- End Of row-->
        </div><!-- End Of container-->
    </div>
</template>

<script>
import moment from 'moment';
import {mapGetters} from "vuex";

export default {
    name: "all_post",
    data() {
        return {
            messageEmpty: null,

        }
    },
    methods: {
        async DeletePost(Post_id) {
            const headers = {
                'Content-type': 'application/json',
                'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
            };
            let res = await axios.get('/api/admin/post/delete/' + Post_id, {headers});

            await this.$store.dispatch('posts', res.data);
            if (res.data.Posts.length === 0) {
                this.messageEmpty = "Sorry!, Not Add Any Posts Yet";
            }
        },
    },
    async beforeMount() {
        const headers = {
            'Content-type': 'application/json',
            'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
        };
        let res = await axios.get('/api/admin/post/all', {headers});
        await this.$store.dispatch('posts', res.data);
        if (res.data.Posts.length === 0) {
            this.messageEmpty = "Sorry!, Not Add Any Posts Yet";
        }
    },
    filters: {
        newFormatDate(value) {
            if (!value) return ''
            value = value.toString()
            if (value) {
                return moment(value).format('MM/DD/YYYY hh:mm');
            }
        },
    },
    computed: {
        ...mapGetters(['posts'])
    },
}
</script>

<style scoped>

</style>
