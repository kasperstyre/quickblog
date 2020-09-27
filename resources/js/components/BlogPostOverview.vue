<template>
    <div id="blogPostOverviewPage">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a href="/" class="navbar-brand unselectable">QuickBlog</a>
            <form class="form-inline">
                <input
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Search blog posts..."
                    v-model="searchQuery"
                >
            </form>
        </nav>
        <div id="blogPostContainer" class="container">
            <blog-post-editor @blogPostCreated="handleBlogPostCreated" />
            <blog-post
                v-for="post in pagedPosts"
                v-bind="post"
                :key="post.id"
            ></blog-post>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item pointer unselectable" :class="pageNumber === 1 ? 'disabled' : null">
                    <a class="page-link" @click="() => pageNumber -= 1">
                        Previous
                    </a>
                </li>
                <li
                    class="page-item pointer unselectable"
                    v-for="number in pageCount"
                    :key="number"
                    :class="pageNumber === number ? 'active' : null"
                >
                    <a class="page-link" @click="() => pageNumber = number">{{number}}</a>
                </li>
                <li class="page-item pointer unselectable" :class="pageNumber === pageCount ? 'disabled' : null">
                    <a class="page-link" @click="() => pageNumber += 1">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
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

const POSTS_PER_PAGE = 4

export default {
    data() {
        return {
            blogPosts: [],
            pageNumber: 1,
            searchQuery: '',
        }
    },
    computed: {
        pageCount() {
            return Math.ceil(this.filteredPosts.length / POSTS_PER_PAGE)
        },
        sortedPosts() {
            return this.blogPosts.sort((a, b) => {
                return b.lastUpdated - a.lastUpdated;
            });
        },
        filteredPosts() {
            return this.sortedPosts.filter(post => {
                let searchableText = post.blogPostContent + post.authorName;

                return searchableText.includes(this.searchQuery);
            });
        },
        pagedPosts() {
            let offset = (this.pageNumber - 1) * POSTS_PER_PAGE;

            return this.filteredPosts.slice(offset, offset + POSTS_PER_PAGE);
        },
    },
    methods: {
        handleBlogPostCreated(createdBlogPost) {
            this.blogPosts.push(new BlogPost(createdBlogPost));
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