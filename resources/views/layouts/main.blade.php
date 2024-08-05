<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @yield('script')
    <script>
        let page = 1;

        document.addEventListener('DOMContentLoaded', function() {
            var logo = document.getElementById('logo');
            var optionsCard = document.getElementById('optionsCard');
            var isVisible = false;

            logo.addEventListener('click', function() {
                if (isVisible) {
                    optionsCard.style.display = 'none';
                    isVisible = false;
                } else {
                    optionsCard.style.display = 'block';
                    isVisible = true;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var chevrons = document.querySelectorAll('.nav-link .bi-chevron-down');

            chevrons.forEach(function(chevron) {
                var link = chevron.closest('.nav-link');
                link.addEventListener('click', function() {
                    chevron.classList.toggle('rotate-180');
                });
            });
        });

        $(document).on('change', '#per_page', function(){
            per_page = $('#per_page').val();
            page = 1;

            load()
        })

        $(document).on('click','.page-link', function(){
            event.preventDefault();
            page = this.text

            if(page == "›" || page == "‹"){
                let href = this.href;
                let url = new URL(href);
                page =  url.searchParams.get('page');
            }

            load();
        })

        function actualPage(){
            let div = $('.active');
            let span = div.find('span');
            page = span.text();
        }

        $('#search').on('keyup', function(){
            load();
        })
    </script>
</body>
</html>