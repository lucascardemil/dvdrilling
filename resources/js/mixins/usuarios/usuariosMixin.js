import axios from 'axios';

export default {
    data() {
        return {
            usuarios: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        async fetchUsuarios() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/usuarios/all');
                this.usuarios = response.data;
            } catch (error) {
                this.errors = 'Failed to load usuarios';
                console.error('Error fetching usuarios:', error);
            } finally {
                this.loading = false;
            }
        },

        async createUsuario(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/api/usuarios/store', {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load usuario';
                console.error('Error crear usuario:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarUsuario(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/usuarios/update/' + data.usuario_id, {
                    rol_id: data.rol_id
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load usuario';
                console.error('Error actualizar usuario:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/usuarios/update-status/' + data.usuario_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load usuario';
                console.error('Error actualizar usuario:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};