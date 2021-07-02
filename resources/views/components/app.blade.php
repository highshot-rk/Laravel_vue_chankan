@include("../components/head")
<body>
	<!-- スマホのみのメニューバー -->
    @include("../components/header")
    @yield('contents')
    @include("../components/footer")
</body>
</html>
