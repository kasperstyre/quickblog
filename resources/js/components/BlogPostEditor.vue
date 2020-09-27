<template>
    <div class="card shadow m-4">
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="blogPostContentInput">What's on your mind?</label>
                    <textarea
                        id="blogPostContentInput"
                        class="form-control"
                        rows="2"
                        v-model="blogPostContent"
                        maxlength="250"
                        @keypress="submitOnEnter"
                    />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary" @click="submitBlogPost">Post</button>
                    <h6 class="text-muted">{{contentLength}} / 250</h6>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            blogPostContent: '',
        }
    },
    computed: {
        contentLength() {
            return this.blogPostContent.length;
        }
    },
    methods: {
        submitOnEnter(event) {
            if (event.keyCode == 13) {
                this.submitBlogPost(event);
            }
        },
        submitBlogPost(event) {
            event.preventDefault();

            axios.post('/api/blog_posts', {
                content: this.blogPostContent
            }).then(response => {
                let createdPost = response.data;

                this.$emit('blogPostCreated', createdPost);

                this.blogPostContent = "";
            });
        }
    }
}
</script>