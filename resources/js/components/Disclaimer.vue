<template>
    <div class="row" id="site-infos">
        <div class="col-6">
            #bugbountytips is a single page website made with love, by hackers for hackers.
            It helps to find tips posted on Twitter using his API.
            Found a bug? Feel free to open an issue on <a href="https://github.com/gwen001/bugbountytips" target="_blank">the official repository</a>.
        </div>
        <div class="col-6">
            This webservice is my contribution to the security industry, if you like it, you can support my work.
            <a href="https://github.com/sponsors/gwen001" title="Sponsor gwen001"><img src="https://raw.githubusercontent.com/gwen001/pentest-tools/master/github-sponsor.jpg" alt="Sponsor gwen001" title="Sponsor gwen001"></a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Disclaimer',
        mounted() {
            if( $(window).width() < 1400 ) {
                $('#site-infos').hide();
            }
        }
    }
</script>

<style>
    #site-infos div {
        padding-left: 5px;
    }
    #site-infos {
        background-color: #FFF;
        border: 1px solid #AAA;
        border-radius: 0.25rem;
        color: #AAA;
        font-size: 0.8rem;
        position: absolute;
        right: 50px;
        text-align: justify;
        top: 30px;
        width: 30rem;
    }
</style>