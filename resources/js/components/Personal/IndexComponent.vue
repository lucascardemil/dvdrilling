<template>
    <div>
        <h3>Personal y Cargos</h3>
        <ul class="nav nav-tabs my-3">
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'personal' }" @click="showTab('personal')" href="#">
                    Personal
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'cargo' }" @click="showTab('cargo')" href="#">
                    Cargo
                </a>
            </li>
        </ul>
        <PersonalComponent v-if="activeTab === 'personal'"></PersonalComponent>
        <CargoComponent v-if="activeTab === 'cargo'"></CargoComponent>
    </div>
</template>


<script>
import PersonalComponent from './PersonalComponent.vue';
import CargoComponent from '../Cargo/CargoComponent.vue';

export default {
    data() {
        return {
            activeTab: 'personal',
        };
    },
    components: {
        PersonalComponent,
        CargoComponent
    },
    methods: {
        showTab(tab) {
            this.activeTab = tab;
        }
    }
}
</script>
