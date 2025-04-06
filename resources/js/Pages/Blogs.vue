<template>
    <div class="container">
        <div
            v-for="post in posts"
            :key="post.id"
            class="post card mb-4 shadow-sm"
        >

            <div class="card-body">
                <h2 class="card-title">{{ post.title }}</h2>
                <p class="card-text">{{ post.content }}</p>

                
                <div v-if="post.tags?.length" class="mb-3">
                    <p>
                        <strong>Tags: </strong>
                        <span
                            v-for="tag in post.tags"
                            :key="tag.id"
                            class="badge bg-primary me-2"
                            >{{ tag.name }}</span
                        >
                    </p>
                </div>
                <p><strong>Likes: </strong>{{ post.likes?.length || 0 }}</p>
                <div v-if="post.image" class="mb-3">
                    <img
                        :src="`/storage/${post.image}`"
                        alt="Post image"
                        class="img-fluid rounded"
                    />
                </div>
            </div>

            <div
                class="card-footer text-muted d-flex justify-content-between align-items-center"
            >
                <div>
                    <button
                        class="btn btn-outline-primary btn-sm"
                        @click="likePost(post)"
                    >
                        Like
                    </button>
                    <button
                        class="btn btn-outline-success btn-sm ms-2"
                        @click="bookmarkPost(post)"
                    >
                        Bookmark
                    </button>
                </div>

                <div>
                    <button
                        class="btn btn-outline-warning btn-sm ms-2"
                        @click="editPost(post)"
                    >
                        Edit
                    </button>
                    <button
                        class="btn btn-outline-danger btn-sm ms-2"
                        @click="deletePost(post.id)"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
function bookmarkPost(post) {
    router.post('/bookmarks', { post_id: post.id }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Bookmarked!');
        },
        onError: () => {
            alert('Failed to bookmark!');
        }
    });
}
// Props
defineProps({
    posts: Array,
});

function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        router.delete(`/delete/${postId}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log("Post deleted successfully!");
            },
            onError: (errors) => {
                console.error("Error deleting post:", errors);
            },
        });
    }
}
</script>

<style scoped>
/* Custom styling */
.post {
    border-radius: 8px;
    overflow: hidden;
}

.post h2 {
    font-size: 1.8rem;
    color: #333;
}

.card-body {
    padding: 20px;
}

.card-footer {
    background-color: #f8f9fa;
}

img {
    width: 100%; 
    height: 400px; 
    object-fit: cover; 
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

/* Button Styling */
.card-footer button {
    margin-right: 10px;
}

.card-footer .btn-sm {
    padding: 5px 10px;
}

.card-footer .btn-outline-primary {
    background-color: #e7f1ff;
}

.card-footer .btn-outline-success {
    background-color: #d4edda;
}

.card-footer .btn-outline-warning {
    background-color: #fff3cd;
}

.card-footer .btn-outline-danger {
    background-color: #f8d7da;
}
</style>
