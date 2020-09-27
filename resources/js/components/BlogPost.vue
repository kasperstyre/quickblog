<template>
    <div class="card shadow m-4">
        <div class="card-body blog-post-body">
            <div class="info-line d-flex flex-row justify-content-between">
                <h5 class="card-title mb-1">{{authorName}}</h5>
                <h6 class="mb-1">{{timeStamp}}</h6>
            </div>
            <hr class="dashed mt-2 mb-2">
            <p class="card-text">{{blogPostContent}}</p>
        </div>
    </div>
</template>
<script>
import vagueTime from 'vague-time';

export default {
    props: {
        authorName: String,
        blogPostContent: String,
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
    }
}
</script>