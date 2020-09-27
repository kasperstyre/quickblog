<template>
    <div class="card shadow m-4" @mouseover="mouseOver = true" @mouseleave="mouseOver = false">
        <div class="card-body blog-post-body">
            <div class="info-line d-flex flex-row justify-content-between">
                <h4 class="card-title mb-1">{{authorName}}</h4>
                <div v-if="mouseOver">
                    <button class="btn btn-sm btn-primary" @click="updateBlogPost">
                        <pencil-icon :size="18" />
                    </button>
                    <button class="btn btn-sm btn-danger" @click="deleteBlogPost">
                        <delete-icon :size="18" />
                    </button>
                </div>
                <h6 v-else class="mb-1">{{timeStamp}}</h6>
            </div>
            <hr class="dashed mt-2 mb-2">
            <p class="card-text">{{content}}</p>
        </div>
    </div>
</template>
<script>
import vagueTime from 'vague-time';

import PencilIcon from 'vue-material-design-icons/Pencil.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';

export default {
    data() {
        return {
            mouseOver: false,
        };
    },
    props: {
        id: Number,
        authorName: String,
        content: String,
        creationTime: Date,
        lastUpdated: Date,
    },
    computed: {
        timeStamp() {
            return vagueTime.get({
                from: new Date(),
                to: this.lastUpdated
            });
        }
    },
    methods: {
        updateBlogPost() {
            this.$emit('updateBlogPost', this.id);
        },
        deleteBlogPost() {
            axios.delete(`/api/blog_posts/${this.id}`).then(response => {
                let deletedBlogPost = response.data;

                this.$emit('blogPostDeleted', deletedBlogPost.id);
            });
        }
    },
    components: {
        PencilIcon,
        DeleteIcon,
    }
}
</script>