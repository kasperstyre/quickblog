<template>
    <div id="blogPostOverviewPage">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a href="/" class="navbar-brand unselectable">QuickBlog</a>
        </nav>
        <div id="blogPostContainer" class="container">
            <blog-post
                v-for="post in sortedPosts"
                v-bind="post"
                :key="post.id"
            ></blog-post>
        </div>
    </div>
</template>
<script>
class BlogPost {
    constructor({ id, content, created_at, updated_at, author }) {
        this.id = id;
        this.blogPostContent = content;
        this.creationTime = new Date(created_at);
        this.lastUpdated = new Date(updated_at);
        this.authorName = author.name;
    }
}

export default {
    data() {
        return {
            blogPosts: [],
        }
    },
    computed: {
        sortedPosts() {
            return this.blogPosts.sort((a, b) => {
                return b.lastUpdated - a.lastUpdated;
            });
        },
    },
    created() {
        axios.get('/api/blog_posts').then(response => {
            let fetchedPosts = response.data;

            fetchedPosts.forEach(post => {
                this.blogPosts.push(new BlogPost(post));
            });
        });
    }
}
</script>