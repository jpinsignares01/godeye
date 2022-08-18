<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-5 col-md-12 text-center">
                <h1> Welcome to <span id="app-title">GodEye</span></h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="mt-3 col-md-8">
                <h3 class="mb-2">Planets:</h3>
                <table v-if="!isProcessing" class="w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Population</th>
                            <th>People</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(planet, index) in dataPlanets.results" :key="index">
                            <td>{{planet.name}}</td>
                            <td>{{planet.population | formatNumber}}</td>
                            <td>{{planet.residents.length}}</td>
                        </tr>
                    </tbody>
                </table>
                <div v-else>
                    <b-spinner size="sm"></b-spinner>
                </div>
                <nav v-if="!isProcessing" class="text-center mt-3 w-100">
                    <ul class="pagination">
                        <button :disabled="!dataPlanets.previous" @click="prevPage()" class="btn btn-secondary">Previous page</button>
                        <li class="page-item"><a class="page-link">{{currentPage}}</a></li>
                        <button :disabled="!dataPlanets.next" @click="nextPage()" class="btn btn-secondary">Next page</button>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dataPlanets: null,
                currentPage: 1,
                isProcessing: true,
            }
        },
        mounted() {
            this.getPlanets();
        },
        methods: {
            getPlanets() {
                let me = this;
                me.isProcessing = true;
                let url = '/api/v1/planets';
                axios.post(url, {
                    'page': me.currentPage,
                })
                .then(function (response) {
                    console.log(response.data.results);
                    me.dataPlanets = response.data;
                    me.isProcessing = false;
                    console.log(me.dataPlanets.previous);
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            // Pagination
            prevPage () {
                this.currentPage--;
                this.getPlanets();
            },
            nextPage () {
                this.currentPage++;
                this.getPlanets();
            },
        },
    }
</script>

<style>
    h1 {
        color: #042475;
    }
    #app-title {
        color: #ffb700;
        font-weight: 600;
    }
    ul.pagination {
        display: inline-flex;
    }
</style>