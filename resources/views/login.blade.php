@extends('layout.app')

@section('content')

    <div class="PageContent">
        <h1>Log In</h1>
        <p class="heading-tag">Good to see you again</p>

        <div class="content">
            <login-form inline-template>

                <div class="LoginForm">
                    @error('email')
                    <div class="MessageBox is-error">
                        {{ $message }}
                    </div>
                    @enderror

                    <form action="/login/" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <label for="email">Username</label>
                        <input class="Input" type="text" name="email" v-model="email" required />

                        <label for="password">Password</label>
                        <input class="Input" type="password" name="password" v-model="password" required />

                        <input type="submit" class="Button is-primary" :class="{'is-disabled': !formReady}" value="Sign In" />
                    </form>
                </div>
            </login-form>
        </div>
    </div>



@endsection
