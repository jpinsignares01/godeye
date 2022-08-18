<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-5 col-md-12 text-center">
                <h1> Welcome to <span class="app-title">GodEye</span></h1>
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
                            <td>
                                <b-button :disabled="planet.residents.length == 0" @click="showPeopleModal(planet)">{{planet.residents.length}}</b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else>
                    <b-spinner size="sm"></b-spinner>
                </div>
                <!-- -->
                <b-modal modal-class="peopleModal" size="lg" v-model="showModal" centered hide-footer hide-header no-close-on-backdrop>
                    <div class="d-block">
                        <div class="col-md-12">
                            <h4 class="text-center">Residents in <span class="app-title">{{showModal ? planetModal.name : ''}}</span></h4>
                        </div>
                        <div v-if="planetModal" class="row">
                            <div class="col">
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">People</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(person, index) in planetModal.residents">
                                                <td class="align-middle"><a class="person-label text-decoration-none" @click="showPerson(person)"><i class="bi bi-eye-fill"></i> {{index}}</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="showPersonSection" class="col-md-4 border border-secondary">
                                <div v-if="isModalProcessing" class="text-center pt-5">
                                    <b-spinner size="sm"></b-spinner>
                                </div>
                                <div v-else>
                                    <p><strong>Name: </strong>{{personData.name}}</p>
                                    <p><strong>Gender: </strong>{{personData.gender}}</p>
                                    <p><strong>Height: </strong>{{personData.height}} ({{personData.height_formated}})</p>
                                    <p><strong>Mass: </strong>{{personData.mass}} ({{personData.mass_formated}})</p>
                                    <p><strong>Eye color: </strong>{{personData.eye_color}}</p>
                                    <p><strong>Skin color: </strong>{{personData.skin_color}}</p>
                                    <p><strong>Hair color: </strong>{{personData.hair_color}}</p>
                                    <p><strong>Birth year: </strong>{{personData.birth_year}}</p>
                                    <p><strong>Vehicles: </strong>{{personData.vehicles.length}}</p>
                                    <p><strong>Starships: </strong>{{personData.starships.length}}</p>
                                    <p><strong>Last edited: </strong>{{personData.edited | date_format}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 col-md-12">
                            <div class="row justify-content-end">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary" @click="showModal = false">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-modal>
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
                //
                //People modal
                showModal: false,
                planetModal: null,
                isModalProcessing: false,
                personData: null,
                showPersonSection: false,
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
                    me.dataPlanets = response.data;
                    me.isProcessing = false;
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
            //People modal
            showPeopleModal(planet) {
                this.planetModal = null;
                this.personData = null;
                let me = this;
                //
                me.planetModal = planet;
                me.showModal = true;
            },
            showPerson(person) {
                let me = this;
                me.showPersonSection = true;
                me.isModalProcessing = true;
                let url = '/api/v1/person';
                axios.post(url, {
                    'person': person,
                })
                .then(function (response) {
                    console.log(response);
                    me.personData = response.data;
                    me.isModalProcessing = false;
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        },
    }
</script>

<style>
    h1 {
        color: #042475;
    }
    .app-title {
        color: #ffb700;
        font-weight: 600;
    }
    ul.pagination {
        display: inline-flex;
    }
    .person-label {
        color: #042475;
        font-weight: 600;
        cursor: pointer;
    }
</style>