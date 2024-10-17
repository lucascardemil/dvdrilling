import axios from 'axios';

export default {
    data() {
        return {
            recursos: [],
            asignarActivo: [],
            loading: false,
            errors: null,
            errors_activo: null,
        };
    },
    methods: {
        async fetchAllAsignarActivo() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/recursos/all-asignar-activos');
                this.asignarActivo = response.data;
            } catch (error) {
                this.errors = 'Failed to load recursos';
                console.error('Error fetching recursos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createRecurso(data) {
            this.loading = true;
            this.errors_activo = null;
            try {
                const response = await axios.post('/recursos/store-activo', {
                    proyecto_id: data.proyecto,
                    activo_id: data.activo
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_activo = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_activo = 'Failed to load activo';
                console.error('Error crear activo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatusRecurso(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/recursos/update-status/' + data.activo_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        },


        async eliminarRecursoActivo(data){
            this.loading = true;
            this.errors_activo = null;
            try {
                const response = await axios.delete('/recursos/delete-activo/' + data.activo_id);

                if (response.data.errors) {
                    this.errors_activo = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_activo = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarAsignarActivo(data) {
            this.loading = true;
            this.errors_activo = null;
            try {
                const response = await axios.put('/recursos/update-activo/' + data.id, {
                    proyecto: data.proyecto
                });

                if (response.data.errors) {
                    this.errors_activo = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_activo = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        },
    }
};
