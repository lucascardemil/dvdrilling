import axios from 'axios';

export default {
    data() {
        return {
            recursos: [],
            asignarPersonal: [],
            loading: false,
            errors: null,
            errors_personal: null,
        };
    },
    methods: {
        async fetchNombreRecursos(name = '') {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/recursos/buscar-nombre/' + name);
                this.recursos = response.data;
            } catch (error) {
                this.errors = 'Failed to load recursos';
                console.error('Error fetching recursos:', error);
            } finally {
                this.loading = false;
            }
        },


        async fetchAllAsignarPersonal() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/recursos/all_asignar_personal');
                this.asignarPersonal = response.data;
            } catch (error) {
                this.errors = 'Failed to load recursos';
                console.error('Error fetching recursos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createRecurso(data) {
            this.loading = true;
            this.errors_personal = null;
            try {
                const response = await axios.post('/api/recursos/store_personal', {
                    proyecto_id: data.proyecto,
                    personal_id: data.personal
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_personal = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_personal = 'Failed to load personal';
                console.error('Error crear personal:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarRecurso(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/recursos/update/' + data.personal_id, {
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

        async actualizarStatusRecurso(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/recursos/update-status/' + data.personal_id, {
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
