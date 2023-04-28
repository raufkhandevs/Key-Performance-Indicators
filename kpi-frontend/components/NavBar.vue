<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark">
            <b-navbar-brand>
                <nuxt-link to="/" class="decoration-none nav-link text-white">ShareSquare</nuxt-link>
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item>
                        <nuxt-link to="/kpi/create" class="nav-link text-white">Create</nuxt-link>
                    </b-nav-item>
                    <b-nav-item>
                        <nuxt-link to="/kpi/upload" class="nav-link text-white">Upload</nuxt-link>
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

