<aside class='menu hidden lg:flex flex-col items-end fixed bottom-4 right-0 p-4 text-right z-50 group/menu text-[1rem]'>
    @if(request()->routeIs('top'))
        <a href="#top">Top</a>
        <a href="#event">Event</a>
        <a href="#agenda">Agenda</a>
        <a href="#about">About</a>
        <a href="#media">Media</a>
        <a href="#topic">Topic</a>
    @endif

    @if(request()->routeIs('profile.*'))
        <a href="{{ route('top') }}"><i class='fa-solid fa-chevron-left'></i> Back</a>
        <a href="#top">Profile</a>
        <a href="#profile-media">My Media</a>
        <a href="#profile-info">My Info</a>
        <a href="#profile-password">My Pwd</a>
        <a href="#profile-delete">My Account</a>
    @endif
</aside>

<script>
    window.onload = function(){

        const sections = document.querySelectorAll(".top-section");
        const menu = document.querySelector(".menu");

        const options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.5
        }

        const callback = (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    document.querySelectorAll(`.menu a`).forEach((link) => link.classList.remove("active"));
                    document.querySelector(`a[href="#${entry.target.id}"]`).classList.add("active");

                    switch (entry.target.id) {
                        case "top":
                        case "event":
                        case "about":
                        case "topic":
                        case "profile-media":
                        case "profile-password":
                            menu.classList.remove("reversed");
                            break;

                        case "agenda":
                        case "media":
                        case "profile-info":
                        case "profile-delete":
                            menu.classList.add("reversed");
                            break;

                    }
                }
            })
        };

        const intersectionObserver = new IntersectionObserver(callback, options)

        // start observing
        sections.forEach((section) => {
            intersectionObserver.observe(section);
        })

    }
</script>
