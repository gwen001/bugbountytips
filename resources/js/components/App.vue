<template>
    <div class="container">
        <div class="row p-3"></div>
        <div class="row">
            <div class="col-5">
                <logo></logo>
            </div>
        </div>
        <div class="row p-4"></div>
        <div class="row">
            <div class="col-12">
                <search></search>
            </div>
        </div>
        <disclaimer></disclaimer>
    </div>
</template>

<script>
    import Disclaimer from './Disclaimer.vue'
    import Logo from './Logo.vue'
    import Search from './Search.vue'

    export default {
        name: 'app',
        components: {
            Disclaimer,
            Logo,
            Search
        }
    }
</script>
