@extends('layout.app')

@section('content')

    <div class="PageContent">

        <div class="hero">
            <div class="content">
                <h1>About MarbleTop</h1>
                <p class="heading-tag">To the well-organised kitchen, tea is but the next great adventure</p>
            </div>
            <img src="/images/logo.svg" class="is-medium" />
        </div>

        <div class="content">
            <p>Hi there, and welcome to the about page for MarbleTop.</p>

            <p><span class="highlighted">MarbleTop</span> is the most recent side project that I've added to my portfolio. Essentially, I wanted
            something that really communicated to prospective clients my competencies as a developer and the level
            of experience and degree of craftsmanship I bring to the table when it comes to constructing full stack applications. But I don't
            have the time in my personal life to create, run and maintain a business on the side, so I settled on
            building a reasonably feature complete "shell" of an application as a demonstration of how I'd go about
            building the real thing. This is that.</p>

            <p>
                <span class="highlighted">MarbleTop</span> addresses the problem of meal-planning and recipe management. It allows the user to set
            up a record of all the potential meals they might want to cook in a given week, make shopping plans based
                on these records and quickly get in and out of the shop picking up only what they need based on
                what they already have in the kitchen at the time of shopping. I actually created a very rough, ad hoc version
                of this sort of application to address this exact need for myself a few years ago -
                <span class="highlighted">MarbleTop</span> is what you get when you take this simple concept and build
                a functioning version of it designed to be distributed to the web.
            </p>

            <p>
                Key points of interest regarding the nature of the project include the following:
            </p>

            <ul>
                <li>
                    <strong>It's built using modern frameworks</strong>: <span class="highlighted">Laravel</span> for the back-end and
                    <span class="highlighted">Vue</span> for the front-end.
                </li>
                <li>
                    <strong>The CSS is all written from scratch</strong>: I didn't rely on any frameworks to aid in the visual design of the
                    site.
                </li>
                <li>
                    <strong>It's fully responsive</strong>: it looks great on mobile, tablet and desktop devices, at all resolutions.
                </li>
                <li>
                    <strong>It's thoroughly tested</strong>: the source code includes a suite of feature, integration and unit tests for the
                    back-end code.
                </li>
                <li>
                    <strong>It's a labour of love</strong>: it might not be as feature complete as an application built for a real
                    business, but what is here has been carefully crafted with a high degree of precision and works
                    exactly as well as any customer would want it to.
                </li>
            </ul>

            <p>You can experiment with this demo version of the application by signing in with the email
            <span class="highlighted">guest@marbletop.co.uk</span> and password <span class="highlighted">password</span>. The
            source code can be viewed at the project's GitHub <a href="#">repository</a>.</p>

            <p>Thanks for swinging by. If you are interested, there are many other projects I've worked on hosted at my <a href="http://alecgullon.co.uk/projects">personal site</a>.</p>

            <p>Cheers,</p>

            <p>Alec</p>
        </div>
    </div>

@endsection
