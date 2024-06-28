<aside class='menu hidden lg:flex flex-col items-end fixed bottom-4 right-0 p-4 text-right z-50 group/menu text-[1rem]'>
    <a href="#top">Top</a>
    <a href="#event">Event</a>
    <a href="#agenda">Agenda</a>
    <a href="#about">About</a>
    <a href="#media">Media</a>
    <a href="#topic">Topic</a>
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
                            menu.classList.remove("reversed");
                            break;

                        case "agenda":
                        case "media":
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
