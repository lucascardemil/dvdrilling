<template>
    <div>
        <ul class="nav nav-tabs mb-5">
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
        <AsignarPersonalComponent v-if="activeTab === 'personal'"></AsignarPersonalComponent>
        <AsignarActivosComponent v-if="activeTab === 'activos'"></AsignarActivosComponent>
    </div>
</template>


<script>
import AsignarPersonalComponent from './AsignarPersonalComponent.vue';
import AsignarActivosComponent from './AsignarActivosComponent.vue';

export default {
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
    }
}
</script>
