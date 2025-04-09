<template>
    <div class="container">
        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <input
                    type="text"
                    class="form-control"
                    v-model="searchQuery"
                    placeholder="Search posts by title or content..."
                    @input="filterPosts"
                />
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <Link
                    href="/CreateBlog"
                    class="nav-link btn btn-primary btn-lg"
                    style="
                        margin-top: 20px;
                        padding-top: 8px;
                        background-color: #007bff;
                        min-width: 200px;
                        height: 50px;
                        font-size: 1.25rem;
                    "
                >
                    Create Blog
                </Link>
            </div>
        </div>

        <!-- Display Posts -->
        <h2 class="mb-4">All Posts</h2>
        <div class="row">
            <div v-for="post in filteredPosts" :key="post.id" class="col-md-6">
                <div class="post card mb-4 shadow-sm">
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

                        <p>
                            <strong>Likes: </strong>{{ post.likes_count || 0 }}
                        </p>

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
                                class="btn"
                                :class="{
                                    'btn-outline-primary': !post.isLiked,
                                    'btn-primary': post.isLiked,
                                }"
                                @click="toggleLike(post)"
                            >
                                {{ post.isLiked ? "Unlike" : "Like" }}
                            </button>

                            <button
                                class="btn btn-outline-success btn-sm ms-2"
                                @click="toggleBookmark(post)"
                            >
                                {{
                                    post.isBookmarked
                                        ? "Bookmarked"
                                        : "Bookmark"
                                }}
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

                    <!-- Comment Section -->
                    <div class="card-footer">
                        <div class="mb-3">
                            <button
                                v-if="!post.showCommentInput"
                                class="btn btn-outline-secondary mt-2"
                                @click="toggleCommentInput(post)"
                            >
                                Add Comment
                            </button>

                            <div v-if="post.showCommentInput">
                                <textarea
                                    v-model="post.newComment"
                                    class="form-control mt-2"
                                    rows="3"
                                    placeholder="Write a comment..."
                                ></textarea>
                                <button
                                    class="btn btn-primary mt-2"
                                    @click="submitComment(post)"
                                >
                                    Submit Comment
                                </button>
                            </div>
                        </div>

                        <div v-if="post.comments?.length" class="comments-list">
                            <h5>Comments:</h5>
                            <ul class="list-unstyled">
                                <li
                                    v-for="(comment, index) in post.comments"
                                    :key="index"
                                >
                                    <div
                                        class="border p-2 mb-2 rounded d-flex justify-content-between align-items-start"
                                    >
                                        <div>
                                            <strong
                                                >{{
                                                    comment.author ||
                                                    "Anonymous"
                                                }}:</strong
                                            >
                                            <p>{{ comment.text }}</p>
                                        </div>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="
                                                deleteComment(comment, post)
                                            "
                                            title="Delete Comment"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Posts Section -->
        <div class="row mb-4">
            <h3>Latest Posts</h3>
            <div v-for="post in latestPosts" :key="post.id" class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ post.title }}</h5>
                        <p class="card-text">
                            {{ post.content.slice(0, 100) }}...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const page = usePage();
const currentUser = computed(() => page.props.auth?.user || null);
const props = defineProps({ posts: Array });
const searchQuery = ref("");
const posts = ref(props.posts);

const filteredPosts = computed(() => {
    let list = [...posts.value];
    list.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    if (!searchQuery.value.trim()) return list;

    return list.filter(
        (post) =>
            post.title
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            post.content.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const latestPosts = computed(() => {
    return posts.value
        .slice()
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 3);
});

function toggleLike(post) {
    const url = post.isLiked
        ? `/posts/${post.id}/unlike`
        : `/posts/${post.id}/like`; // Adjusted URL to match your routes
    const method = post.isLiked ? "DELETE" : "POST"; // Use DELETE for unliking, POST for liking

    // Optimistic UI update: assume success immediately
    post.isLiked = !post.isLiked; // Toggle the like status locally
    post.likes_count = post.isLiked
        ? (post.likes_count || 0) + 1
        : (post.likes_count || 0) - 1;

    // Toggle like status in the backend using Inertia's router
    router.visit(url, {
        method: method,
        data: {},
        preserveScroll: true,
        onSuccess: () => {
            // Successfully toggled like, update UI
            post.likes_count = post.isLiked
                ? (post.likes_count || 0) + 1
                : (post.likes_count || 0) - 1;
        },
        onError: (error) => {
            // On failure, revert the optimistic UI change
            post.isLiked = !post.isLiked;
            post.likes_count = post.isLiked
                ? (post.likes_count || 0) + 1
                : (post.likes_count || 0) - 1;
            console.error("Error while liking/unliking:", error);
        },
    });
}

function toggleBookmark(post) {
    if (post.isBookmarked) {
        router.delete(`/bookmarks/${post.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                post.isBookmarked = false;
                window.dispatchEvent(new CustomEvent("bookmarks-updated"));
            },
        });
    } else {
        router.post(
            "/bookmarks",
            { post_id: post.id },
            {
                preserveScroll: true,
                onSuccess: () => {
                    post.isBookmarked = true;
                    window.dispatchEvent(new CustomEvent("bookmarks-updated"));
                },
            }
        );
    }
}

function editPost(post) {
    router.get(`/edit/${post.id}`);
}

function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        router.delete(`/delete/${postId}`, {
            preserveScroll: true,
        });
    }
}

function toggleCommentInput(post) {
    post.showCommentInput = !post.showCommentInput;
}

function submitComment(post) {
    if (!post.newComment?.trim()) return;

    router.post(
        `/posts/${post.id}/comments`,
        {
            content: post.newComment,
            parent_id: null,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                const newComment = {
                    author: currentUser.value?.email || "Anonymous",
                    text: post.newComment,
                    id: Math.random().toString(36).substring(7),
                };
                post.comments.push(newComment);
                post.newComment = "";
                post.showCommentInput = false;
            },
        }
    );
}

function deleteComment(comment, post) {
    if (confirm("Are you sure you want to delete this comment?")) {
        router.delete(`/comments/${comment.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                post.comments = post.comments.filter(
                    (c) => c.id !== comment.id
                );
            },
            onError: (error) => {
                console.error("Failed to delete comment:", error);
            },
        });
    }
}

onMounted(() => {
    posts.value.forEach((post) => {
        post.isLiked = false;
        post.isBookmarked = false;
        post.likes_count = post.likes_count || 0;
        post.comments = post.comments || [];
        post.showCommentInput = false;
        post.newComment = "";
    });
});
</script>

<style scoped>
.post {
    border-radius: 8px;
    overflow: hidden;
}
.card-body {
    padding: 20px;
}
.card-footer {
    background-color: #f8f9fa;
}
input.form-control {
    margin-top: 20px;
    height: 45px;
    font-size: 1.1rem;
}
img {
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.card-text {
    max-height: 80px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
}
.card-footer button {
    margin-right: 10px;
}
.card-footer .btn-sm {
    padding: 5px 10px;
}
.card-footer .btn-outline-primary {
    background-color: #e7f1ff;
}
.card-footer .btn-primary {
    background-color: #007bff;
    color: white;
}
.card-footer .btn-outline-success {
    background-color: #d4edda;
}
.card-footer .btn-outline-warning {
    background-color: #fff3cd;
}
</style>
