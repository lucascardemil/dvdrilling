import axios from 'axios';

export default {
    data() {
        return {
            perforaciones: [],
            errors_perforaciones: [],
            loading_create: false
        };
    },
    methods: {

        async fetchPerforaciones(id) {
            this.loading = true;
            this.errors_perforaciones = null;
            try {
                const response = await axios.get(`/perforaciones/all/${id}`);
                this.perforaciones = response.data;
            } catch (error) {
                this.errors_perforaciones = 'Failed to load perforaciones';
                console.error('Error fetching perforaciones:', error);
            } finally {
                this.loading = false;
            }
        },

        async createPerforaciones(data) {
            this.loading_create = true;
            this.errors_perforaciones = null;
            try {
                const response = await axios.post('/perforaciones/store', data);

                if (response.data.errors) {
                    this.errors_perforaciones = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_perforaciones = 'Failed to load perforaciones';
                console.error('Error crear perforaciones:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async actualizarPerforacion(data) {
            this.loading_create = true;
            this.errors_perforaciones = null;
            try {
                const response = await axios.put('/perforaciones/update/' + data.id, {
                    desde: data.desde,
                    hasta: data.hasta,
                    perforado: data.perforado,
                    recuperado: data.recuperado,
                    porcentaje: data.porcentaje,
                    numero_cajas: data.numero_cajas
                });

                if (response.data.errors) {
                    this.errors_perforaciones = response.data.errors_reporte;
                }

                return response.data;

            } catch (error) {
                this.errors_perforaciones = 'Failed to load perforaciones';
                console.error('Error actualizar perforaciones:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async deletePerforacion(id) {
            this.loading = true;
            this.errors_perforaciones = null;
            try {
                const response = await axios.delete('/perforaciones/delete/' + id);

                if (response.data.errors) {
                    this.errors_perforaciones = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_perforaciones = 'Failed to load perforaciones';
                console.error('Error actualizar perforaciones:', error);
            } finally {
                this.loading = false;
            }
        },


    }
};
