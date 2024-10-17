import axios from 'axios';

export default {
    data() {
        return {
            personals: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        async fetchNombrePersonals(name = '') {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/personals/buscar-nombre/' + name);
                this.personals = response.data;
            } catch (error) {
                this.errors = 'Failed to load personals';
                console.error('Error fetching personals:', error);
            } finally {
                this.loading = false;
            }
        },


        async fetchPersonals() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/personals/all');
                this.personals = response.data;
            } catch (error) {
                this.errors = 'Failed to load personals';
                console.error('Error fetching personals:', error);
            } finally {
                this.loading = false;
            }
        },

        async createPersonal(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/personals/store', {
                    name: data.name,
                    apellido_paterno: data.apellido_paterno,
                    apellido_materno: data.apellido_materno,
                    run: data.run,
                    cargo_id: data.cargo
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load personal';
                console.error('Error crear personal:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarPersonal(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/personals/update/' + data.personal_id, {
                    name: data.name,
                    apellido_paterno: data.apellido_paterno,
                    apellido_materno: data.apellido_materno,
                    run: data.run,
                    cargo_id: data.cargo
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load personal';
                console.error('Error actualizar personal:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatusPersonal(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/personals/update-status/' + data.personal_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load personal';
                console.error('Error actualizar personal:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
