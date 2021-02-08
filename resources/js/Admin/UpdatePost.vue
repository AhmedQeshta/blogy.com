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
                    <li class="nav-item dropdown">
                        <a v-if="this.$store.getters.adminInfo" class="nav-link dropdown-toggle" data-toggle="dropdown"
                           href="javascript:void(0);">{{ this.$store.getters.adminInfo.data.name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a v-if="admin" class="dropdown-item" href="javascript:void(0);" @click.prevent="logout">logout</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{path:'/admin/dashboard/post'}" class="nav-link">All Post</router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            update Post {{ $route.params.id }}
                        </div>
                        <div v-if="this.errors" class="alert alert-danger m-2">
                            {{ this.errors }}
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="onUpdateForm">
                                <div class="form-group">
                                    <label for="title_post">Title</label>
                                    <input id="title_post" v-model.trim="Post.title" class="form-control" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="body_post">Body</label>
                                    <textarea id="body_post" v-model.trim="Post.body" class="form-control" cols="30"
                                              name=""
                                              rows="7"></textarea>
                                </div>
                                <div class="form-group">
                                    <div v-if="this.loadImage" class="w-50 mx-auto">
                                        <img :alt="post.title" :src="'https://blogy.com.test/' + this.loadImage "
                                             class="img-fluid w-75">
                                    </div>
                                    <label for="file_post">Image</label>
                                    <input id="file_post" class="form-control" type="file"
                                           @change.prevent="onUploadImage">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Update POST</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End Of col-->
            </div><!-- End Of row-->
        </div><!-- End Of container-->
    </div>
</template>

<script>
import NavBar from "../components/navBar";
import {mapGetters} from "vuex";

export default {
    name: "UpdatePost",
    components: {NavBar},
    data() {
        return {
            Post: {
                title: null,
                body: null,
                image: null,
            },
            loadImage: null,
            errors: null,
        }
    },
    methods: {
        async logout() {
            const headers = {
                'Content-type': 'application/json',
                'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
            };
            await axios.post('/api/admin/logout', {}, {headers});
            localStorage.removeItem("token");
            localStorage.removeItem("token_type");
            this.$store.dispatch('admin', null);
            localStorage.removeItem("vuex");
            this.$router.push({path: '/login'});
        },
        onUploadImage(e) {
            let fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);

            fileReader.onload = (e) => {
                this.Post.image = e.target.result;
            }

        },
        async onUpdateForm() {
            try {
                const headers = {
                    'Content-type': 'application/json',
                    'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
                };
                let res = await axios.post('/api/admin/post/update/' + this.$route.params.id, this.$data.Post, {headers});
                await this.$store.dispatch('posts', res.data);
                await this.$router.push({path: '/admin/dashboard/post'});
                this.Post.body = null;
                this.Post.title = null;
                this.Post.image = null;
            } catch (e) {
                this.errors = 'Invaded data';
            }

        },
    },

    async beforeMount() {
        const headers = {
            'Content-type': 'application/json',
            'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
        };
        let res = await axios.get('/api/admin/AdminInformation', {headers});
        await this.$store.dispatch('adminInfo', res.data);
        let response = await axios.get('/api/admin/post/show/' + this.$route.params.id, {headers});
        await this.$store.dispatch('post', response.data);
        this.Post.title = this.$store.getters.post.data.title;
        this.Post.body = this.$store.getters.post.data.body;
        this.loadImage = this.$store.getters.post.data.image;
    },
    computed: {
        ...mapGetters(['admin', 'adminInfo', 'post'])
    },
}
</script>

<style scoped>

</style>
