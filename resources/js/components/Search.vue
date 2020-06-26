<template>
    <div class="row">
        <div class="col-12">
            <form v-on:submit.prevent="onSubmit">
                <input type="hidden" id="page" name="p" v-model="p">
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
                    <div id="results-container" class="d-flex flex-wrap">
                        <div v-for="result in results" :key="result.id">
                            <Tweet v-bind:id="result.twitter_id"></Tweet>
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
                p: 0,
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
                // this.results = [];
                // alert(this.q);
                await axios.get('/api/tweets?q='+this.q+'&p='+this.p).then((res) => {
                    if( res.data && res.data.length ) {
                        this.results = this.results.concat( res.data );
                        this.p++;
                        window.setTimeout( this.searchTweets, 3000 );
                    }
                    // this.focusInput();
                })
            },
            onSubmit() {
                this.results = [];
                this.p = 0;
                this.searchTweets();
            }
        }
    }
</script>

<style>
    label {
        max-width: 120px !important;
    }
    twitter-widget, iframe {
        margin-right: 10px;
        /*max-width: 220px !important;
        width: 220px !important; */
    }
</style>