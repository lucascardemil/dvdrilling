import axios from 'axios';

export default {
    data() {
        return {
            coronasEscareadores: [],
            errors_coronasEscareadores: [],
            loading_create: false
        };
    },
    methods: {

        async fetchCoronasEscareadores(id) {
            this.loading = true;
            this.errors_coronasEscareadores = null;
            try {
                const response = await axios.get(`/coronasEscareadores/all/${id}`);
                this.coronasEscareadores = response.data;
            } catch (error) {
                this.errors_coronasEscareadores = 'Failed to load coronasEscareadores';
                console.error('Error fetching coronasEscareadores:', error);
            } finally {
                this.loading = false;
            }
        },

        async createCoronasEscareadores(data) {
            this.loading_create = true;
            this.errors_coronasEscareadores = null;
            try {
                const response = await axios.post('/coronasEscareadores/store', data);

                if (response.data.errors) {
                    this.errors_coronasEscareadores = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_coronasEscareadores = 'Failed to load coronasEscareadores';
                console.error('Error crear coronasEscareadores:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async actualizarCoronaEscareador(data) {
            this.loading = true;
            this.errors_coronasEscareadores = null;
            try {
                const response = await axios.put('/coronasEscareadores/update/' + data.id, {
                    detalle: data.detalle,
                    desde: data.desde,
                    hasta: data.hasta,
                    diametro: data.diametro,
                    numero_corona: data.numero_corona
                });

                if (response.data.errors) {
                    this.errors_coronasEscareadores = response.data.errors_reporte;
                }

                return response.data;

            } catch (error) {
                this.errors_coronasEscareadores = 'Failed to load coronasEscareadores';
                console.error('Error actualizar coronasEscareadores:', error);
            } finally {
                this.loading = false;
            }
        },

        async deleteCoronaEscareador(id) {
            this.loading = true;
            this.errors_coronasEscareadores = null;
            try {
                const response = await axios.delete('/coronasEscareadores/delete/' + id);

                if (response.data.errors) {
                    this.errors_coronasEscareadores = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_coronasEscareadores = 'Failed to load coronasEscareadores';
                console.error('Error actualizar coronasEscareadores:', error);
            } finally {
                this.loading = false;
            }
        },


    }
};
