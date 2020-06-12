<template>
    <div class="row">
        <div class="col-12">
            <form @submit="searchTweets" v-on:submit.prevent="onSubmit">
                <input type="hidden" id="page" name="page" value="1">
                <div class="form-group row">
                    <label for="q" class="col-2 col-form-label">Search for:</label>
                    <div class="col-2">
                        <input type="text" class="form-control" v-model="q" ref="q" name="q">
                    </div>
                    <div class="col-3">
                        <button type="submit" id="btn-search" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

            <div class="p-3"></div>

            <div class="row">
                <div class="col-12">
                    <div id="results-container">
                        <div v-for="result in results" :key="result.id">
                            <Tweet v-bind:id="result.twitter_id"><div class="spinner"></div></Tweet>
                        </div>
                    </div>
                    <div id="result-error" class="d-none alert alert-danger text-center" role="alert">
                    </div>
                    <div class="d-flex justify-content-center">
                        <div id="search-spinner" class="spinner-border text-primary d-none" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { Tweet } from 'vue-tweet-embed'

    export default {
        name: 'Search',
        components: {
            Tweet
        },
        data: function () {
            return {
                q: '',
                results: []
            }
        },
        mounted() {
            this.focusInput();
            this.searchTweets();
        },
        methods: {
            focusInput() {
                this.$refs.q.focus();
            },
            async searchTweets(e) {
                this.results = [];
                // alert(this.q);
                await axios.get('http://bugbountytips.test.net/api/tweets?q='+this.q).then((res) => {
                    this.results = res.data;
                    this.focusInput();
                })
            },
            onSubmit() {
                ;
            }
        }
    }
</script>

<style>
    label {
        max-width: 120px !important;
    }
    iframe {
        display: inline-block;
        /* margin:  0.25rem; */
        padding:  1rem;
        width:  100%;
        margin-top: 0px !important;
        /* float: left; */
        /* margin-top: 0px !important;
        margin-right: 10px;
        max-width: 220px !important; */
    }

    #results-container {
        -moz-column-width: 18em;
        -webkit-column-width: 18em;
        -moz-column-gap: 1em;
        -webkit-column-gap: 1em;
    }
    #results-container input {
        margin-bottom: 5px;
        width: 100%;
    }
</style>