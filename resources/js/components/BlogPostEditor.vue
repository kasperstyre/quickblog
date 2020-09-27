<template>
    <div class="card shadow m-4">
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label v-if="blogPostId === null" for="blogPostContentInput">What's on your mind?</label>
                    <label v-else for="blogPostContentInput">What should the blog post say instead?</label>
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
                    <button v-if="blogPostId === null" type="submit" class="btn btn-primary" @click="submitBlogPost">Post</button>
                    <div v-else>
                        <button type="submit" class="btn btn-primary" @click="updateBlogPost">Edit</button>
                        <button type="submit" class="btn btn-secondary" @click="cancelBlogPostUpdate">Cancel</button>
                    </div>
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
            blogPostId: null,
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
            if (event.keyCode !== 13) return;

            if (this.blogPostId === null) {
                this.submitBlogPost(event);
            } else {
                this.updateBlogPost(event);
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
        },
        updateBlogPost(event) {
            event.preventDefault();

            axios.put(`/api/blog_posts/${this.blogPostId}`, {
                content: this.blogPostContent
            }).then(response => {
                let updatedBlogPost = response.data;

                this.$emit('blogPostUpdated', updatedBlogPost);

                this.resetEditor();
            });
        },
        cancelBlogPostUpdate(event) {
            event.preventDefault();

            this.resetEditor();
        },
        resetEditor() {
            this.blogPostId = null;
            this.blogPostContent = '';
        }
    },
    created() {
        this.$on('updateBlogPost', blogPost => {
            this.blogPostId = blogPost.id;
            this.blogPostContent = blogPost.content;
        });
    }
}
</script>