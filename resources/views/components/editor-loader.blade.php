<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>

<script>
    const quillEN = new Quill('#editor_en', { theme: 'snow' });
    const quillJA = new Quill('#editor_ja', { theme: 'snow' });

    // add default height to avoid css bug
    document.getElementById("editor_en").style.height = '200px';
    document.getElementById("editor_ja").style.height = '200px';

    quillJA.on('text-change', function() {
        document.getElementById("description_ja").value = quillJA.root.innerHTML;
    });

    quillEN.on('text-change', function() {
        document.getElementById("description_en").value = quillEN.root.innerHTML;
    });
</script>
