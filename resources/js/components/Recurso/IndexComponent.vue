<template>
    <div>
        <h3>Asignar Personal y Asignar Activos</h3>
        <ul class="nav nav-tabs my-3">
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'personal' }" @click="showTab('personal')" href="#">
                    Asignar Personal
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'activos' }" @click="showTab('activos')" href="#">
                    Asignar Activos
                </a>
            </li>
        </ul>
        <AsignarPersonalComponent v-if="activeTab === 'personal'" :proyectos="proyectos"></AsignarPersonalComponent>
        <AsignarActivosComponent v-if="activeTab === 'activos'" :proyectos="proyectos"></AsignarActivosComponent>
    </div>
</template>


<script>
import AsignarPersonalComponent from './AsignarPersonal/AsignarPersonalComponent.vue';
import AsignarActivosComponent from './AsignarActivo/AsignarActivosComponent.vue';
import proyectoMixin from '../../mixins/proyecto/proyectoMixin';

export default {
    mixins: [proyectoMixin],
    data() {
        return {
            activeTab: 'personal',
        };
    },
    components: {
        AsignarPersonalComponent,
        AsignarActivosComponent
    },
    methods: {
        showTab(tab) {
            this.activeTab = tab;
        }
    },
    created() {
        this.fetchProyectosSelect();
    }
}
</script>
