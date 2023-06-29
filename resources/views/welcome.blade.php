@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-6">
                <h2>Agregar Usuario</h2>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" required @change="getUserNationality(newUser.name)">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellidos</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Edad</label>
                        <input type="number" name="age" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Sexo</label>
                        <select name="gender" class="form-control" required>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Usuarios</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->age }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
			<div class="col-md-6">
				<h2>Nacionalidad</h2>
				<p>Nacionalidad: {{ userNationality }}</p>
			</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Datos Estadísticos</h2>
                <p>Edad promedio: {{ $averageAge }}</p>
                <p>Cantidad de personas por sexo:</p>
                <ul>
                    <li>Masculino: {{ $maleCount }}</li>
                    <li>Femenino: {{ $femaleCount }}</li>
                </ul>
                <p>Persona de menor edad: {{ $youngestPerson }}</p>
                <p>Persona de mayor edad: {{ $oldestPerson }}</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
				userNationality: '',
                users: [],
                newUser: {
                    name: '',
                    last_name: '',
                    age: '',
                    gender: '',
                    email: '',
                    password: ''
                }
            },
            mounted() {
                this.getUsers();
            },
            methods: {
                getUsers() {
                    axios.get('/users')
                        .then(response => {
                            this.users = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },
                addUser() {
                    axios.post('/users', this.newUser)
                        .then(response => {
                            console.log(response.data);
                            this.getUsers();
                            this.clearForm();
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },
                clearForm() {
                    this.newUser = {
                        name: '',
                        last_name: '',
                        age: '',
                        gender: '',
                        email: '',
                        password: ''
                    };
                },
				getUserNationality(name) {
                    axios.get(`https://api.nationalize.io/?name=${name}`)
                        .then(response => {
                            // Obtener la nacionalidad de mayor probabilidad
                            if (response.data.country && response.data.country.length > 0) {
                                this.userNationality = response.data.country[0].country_id;
                            } else {
                                this.userNationality = 'Desconocida';
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            }
        });
    </script>
@endsection
