<template>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <!-- Left-aligned Links -->
                <Link href="/" class="navbar-brand">MyBlog</Link>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <Link href="/CreateBlog" class="nav-link"
                                >Create Blog</Link
                            >
                        </li>
                        <li class="nav-item">
                            <Link href="/ShowBlogs" class="nav-link"
                                >Blogs</Link
                            >
                        </li>
                        <li class="nav-item">
                            <Link href="/bookmarks" class="nav-link"
                                >Bookmarks</Link
                            >
                        </li>
                    </ul>

                    <!-- Right-aligned Links -->
                    <ul class="navbar-nav">
                        <template v-if="userProfilePic">
                            <li class="nav-item">
                                <Link href="/ProfilePage" class="nav-link">
                                    <!-- Profile Picture -->
                                    <img
                                        v-if="userProfilePic"
                                        :src="`/storage/${userProfilePic}`"
                                        alt=""
                                        class="rounded-circle"
                                        width="20"
                                        height="20"
                                    />
                                    <img
                                        v-else
                                        src="/images/default-avatar.png"
                                        alt="Default Profile Picture"
                                        class="rounded-circle"
                                        width="30"
                                        height="30"
                                    />
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link href="/user-logout" class="nav-link"
                                    >Logout</Link
                                >
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item">
                                <Link href="/login" class="nav-link"
                                    >Login</Link
                                >
                            </li>
                            <li class="nav-item">
                                <Link href="/register" class="nav-link"
                                    >Register</Link
                                >
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- About Blog Section -->
        <section id="about-blog" class="bg-light py-5">
            <div class="container">
                <h2 class="text-dark">About My Blog</h2>
                <p class="text-muted">
                    Welcome to MyBlog, a platform where you can share your
                    thoughts, ideas, and experiences with the world. Whether
                    you're passionate about technology, lifestyle, or any other
                    topic, MyBlog offers a space to express yourself and connect
                    with others.
                    <br /><br />
                    Explore different categories, create your own posts,
                    interact with fellow bloggers through comments and likes,
                    and enjoy a rich community experience. Join us and be part
                    of this vibrant blogging community.
                </p>
            </div>
        </section>

        <!-- Category Section -->
        <section id="category" class="py-5">
            <div class="container">
                <h2 class="text-primary">Blog Category</h2>
                <p class="text-muted">
                    Discover posts from various categories. Whether you are
                    interested in tech, lifestyle, or something else, explore
                    different topics to find something that interests you.
                </p>
                <!-- Category items -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img
                                src="https://i.ibb.co.com/fV6vmH57/t.jpg"
                                class="card-img-top"
                                alt="Category Image"
                            />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Tech</h5>
                                <p class="card-text text-muted">
                                    Explore the latest in technology, gadgets,
                                    software, and more.
                                </p>
                                <Link class="btn btn-primary">View Posts</Link>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img
                                src="https://i.ibb.co.com/fV6vmH57/t.jpg"
                                class="card-img-top"
                                alt="Category Image"
                            />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Lifestyle</h5>
                                <p class="card-text text-muted">
                                    Get inspiration on living a balanced,
                                    healthy lifestyle.
                                </p>
                                <Link
                                    href="/category/lifestyle"
                                    class="btn btn-primary"
                                    >View Posts</Link
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img
                                src="https://i.ibb.co.com/fV6vmH57/t.jpg"
                                class="card-img-top"
                                alt="Category Image"
                            />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Travel</h5>
                                <p class="card-text text-muted">
                                    Travel stories, guides, and tips from all
                                    around the world.
                                </p>
                                <Link
                                    href="/category/travel"
                                    class="btn btn-primary"
                                    >View Posts</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Customer Section -->
        <section id="customer" class="bg-light py-5">
            <div class="container">
                <h2 class="text-primary">Reaction from bloggers</h2>
                <p class="text-muted">
                    Learn about our loyal customers, their experiences, and why
                    they love our platform.
                </p>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-dark">John Doe</h5>
                                <p class="card-text text-muted">
                                    "MyBlog has been a great platform to share
                                    my thoughts and connect with people around
                                    the world."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-dark">Jane Smith</h5>
                                <p class="card-text text-muted">
                                    "I love how easy it is to interact with
                                    other bloggers and explore different
                                    categories."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-dark">Jane Smith</h5>
                                <p class="card-text text-muted">
                                    "I love how easy it is to interact with
                                    other bloggers and explore different
                                    categories."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="d-flex justify-content-center align-items-center">
            <Link
                href="/ShowBlogs"
                class="nav-link btn btn-primary btn-lg"
                style="
                 background-color: #007bff;
                    min-width: 200px;
                    height: 50px;
                    font-size: 1.25rem;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                "
            >
                Blogs
            </Link>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <Link
                href="/CreateBlog"
                class="nav-link btn btn-primary btn-lg"
                style="
                    margin-top: 5px;
                    background-color: #007bff;
                    min-width: 200px;
                    height: 50px;
                    font-size: 1.25rem;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                "
            >
                Create Blog
            </Link>
        </div>

    
        <!-- Content Section -->
        <div id="content" class="content">
            <div class="container-fluid">
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 MyBlog. All rights reserved.</p>
</footer>

</template>

<script setup>
import { Link } from "@inertiajs/vue3";

// Assuming that you are passing user profile info from the backend
const userProfilePic = "{{ auth()->user()->profile_picture ?? null }}"; // Laravel example to pass profile picture
</script>

<style scoped>
#about-blog {
    background-color: #f8f9fa;
    padding: 30px 0;
}

#category,
#customer,
#create-sale,
#invoice {
    padding: 30px 0;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.card-text {
    font-size: 1rem;
    color: #555;
}
</style>
