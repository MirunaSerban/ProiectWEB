document.addEventListener('DOMContentLoaded', function() {
    // Initialize the SVG drawing
    const mapContainer = document.getElementById('romania-map');
    const containerWidth = mapContainer.clientWidth;
    const containerHeight = mapContainer.clientHeight;
    
    // Create SVG with viewBox for better scaling
    const draw = SVG().addTo('#romania-map').size(containerWidth, containerHeight).viewbox(0, 0, containerWidth, containerHeight);
    const mapGroup = draw.group();
    
    // Definim coordonatele județelor
    const counties = {
        'AB': 'Alba',
        'AR': 'Arad',
        'AG': 'Argeș',
        'BC': 'Bacău',
        'BH': 'Bihor',
        'BN': 'Bistrița-Năsăud',
        'BT': 'Botoșani',
        'BV': 'Brașov',
        'BR': 'Brăila',
        'B': 'București',
        'BZ': 'Buzău',
        'CS': 'Caraș-Severin',
        'CL': 'Călărași',
        'CJ': 'Cluj',
        'CT': 'Constanța',
        'CV': 'Covasna',
        'DB': 'Dâmbovița',
        'DJ': 'Dolj',
        'GL': 'Galați',
        'GR': 'Giurgiu',
        'GJ': 'Gorj',
        'HR': 'Harghita',
        'HD': 'Hunedoara',
        'IL': 'Ialomița',
        'IS': 'Iași',
        'IF': 'Ilfov',
        'MM': 'Maramureș',
        'MH': 'Mehedinți',
        'MS': 'Mureș',
        'NT': 'Neamț',
        'OT': 'Olt',
        'PH': 'Prahova',
        'SM': 'Satu Mare',
        'SJ': 'Sălaj',
        'SB': 'Sibiu',
        'SV': 'Suceava',
        'TR': 'Teleorman',
        'TM': 'Timiș',
        'TL': 'Tulcea',
        'VS': 'Vaslui',
        'VL': 'Vâlcea',
        'VN': 'Vrancea'
    };

    // Funcție pentru încărcarea adăposturilor pentru un județ
    function loadShelters(county) {
        console.log('Loading shelters for county:', county); // Debug log
        
        fetch(`php/get_shelters.php?judet=${encodeURIComponent(county)}`)
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data); // Debug log
                
                const container = document.getElementById('shelters-container');
                if (!data || data.length === 0) {
                    container.innerHTML = `<p class="no-shelters">Nu există adăposturi înregistrate în județul ${county}</p>`;
                    return;
                }

                container.innerHTML = data.map(shelter => `
                    <div class="shelter-item">
                        <h4>${shelter.nume}</h4>
                        <p><strong>Oraș:</strong> ${shelter.oras}</p>
                        <p><strong>Adresă:</strong> ${shelter.adresa || 'N/A'}</p>
                        <div class="contact">
                            <p><strong>Tel:</strong> ${shelter.telefon || 'N/A'}</p>
                            ${shelter.email ? `<p><strong>Email:</strong> <a href="mailto:${shelter.email}">${shelter.email}</a></p>` : ''}
                            ${shelter.website ? `<p><strong>Website:</strong> <a href="${shelter.website}" target="_blank">Vizitează site-ul</a></p>` : ''}
                        </div>
                    </div>
                `).join('');
            })
            .catch(error => {
                console.error('Eroare la încărcarea adăposturilor:', error);
                document.getElementById('shelters-container').innerHTML = 
                    '<p class="error">A apărut o eroare la încărcarea adăposturilor. Te rugăm să încerci din nou.</p>';
            });
    }

    // Load the SVG file
    fetch('images/ro.svg')
        .then(response => response.text())
        .then(svgContent => {
            // Create a temporary div to parse the SVG
            const parser = new DOMParser();
            const svgDoc = parser.parseFromString(svgContent, 'image/svg+xml');
            
            // Get the viewBox from the original SVG if it exists
            const originalSvg = svgDoc.querySelector('svg');
            const viewBox = originalSvg.getAttribute('viewBox');
            if (viewBox) {
                draw.viewbox(viewBox);
            }

            const paths = svgDoc.querySelectorAll('path');
            
            // Add each path to our SVG.js instance
            paths.forEach(path => {
                const pathElement = mapGroup.path(path.getAttribute('d'));
                const fullId = path.getAttribute('id');
                const countyId = fullId.replace('RO', '');
                
                pathElement
                    .fill('#EAEAEA')
                    .stroke({ color: '#FFFFFF', width: 1 })
                    .attr('id', countyId)
                    .attr('class', 'county');

                // Add hover effects
                pathElement.on('mouseover', function(event) {
                    this.fill({ color: '#D5D5D5' });
                    const tooltip = document.createElement('div');
                    tooltip.className = 'county-tooltip';
                    tooltip.textContent = counties[countyId];
                    tooltip.style.position = 'absolute';
                    tooltip.style.left = event.pageX + 10 + 'px';
                    tooltip.style.top = event.pageY + 10 + 'px';
                    document.body.appendChild(tooltip);
                });

                pathElement.on('mouseout', function() {
                    if (!this.hasClass('selected')) {
                        this.fill({ color: '#EAEAEA' });
                    }
                    const tooltips = document.querySelectorAll('.county-tooltip');
                    tooltips.forEach(t => t.remove());
                });

                pathElement.on('click', function() {
                    mapGroup.find('.selected').forEach(el => {
                        el.removeClass('selected');
                        el.fill({ color: '#EAEAEA' });
                    });
                    this.addClass('selected');
                    this.fill({ color: '#D5D5D5' });
                    loadShelters(counties[countyId]);
                });
            });

            // Get the bounding box of the map
            const bbox = mapGroup.bbox();
            
            // Calculate the scale to fit the map in the container with padding
            const padding = 40;
            const scaleX = (containerWidth - padding) / bbox.width;
            const scaleY = (containerHeight - padding) / bbox.height;
            const scale = Math.min(scaleX, scaleY);
            
            // Calculate centering offsets with adjustment
            const scaledWidth = bbox.width * scale;
            const scaledHeight = bbox.height * scale;
            const translateX = (containerWidth - scaledWidth) / 2 - 65; // mărit de la 50 la 65px spre stânga
            const translateY = (containerHeight - scaledHeight) / 2 - 30; // păstrăm 30px în sus

            // Reset the group position and apply the transformation
            mapGroup.move(0, 0).transform({
                translateX: translateX,
                translateY: translateY,
                scale: scale
            });

            // Set initial zoom level
            currentZoom = scale;

            // Update pan handling to maintain the offset
            let isPanning = false;
            let startPoint = { x: 0, y: 0 };
            let currentTranslate = { x: translateX, y: translateY };

            draw.on('mousedown', function(event) {
                isPanning = true;
                draw.css('cursor', 'grabbing');
                startPoint = {
                    x: event.clientX - currentTranslate.x,
                    y: event.clientY - currentTranslate.y
                };
            });

            draw.on('mousemove', function(event) {
                if (isPanning) {
                    currentTranslate = {
                        x: event.clientX - startPoint.x,
                        y: event.clientY - startPoint.y
                    };
                    mapGroup.transform({
                        translateX: currentTranslate.x,
                        translateY: currentTranslate.y,
                        scale: currentZoom
                    });
                }
            });

            draw.on('mouseup mouseleave', function() {
                isPanning = false;
                draw.css('cursor', 'grab');
            });

            // Add mouse wheel zoom
            draw.on('wheel', function(event) {
                event.preventDefault();
                const delta = event.deltaY;
                
                if (delta > 0 && currentZoom > zoomStep) { // Zoom out
                    currentZoom -= zoomStep;
                } else if (delta < 0) { // Zoom in
                    currentZoom += zoomStep;
                }
                
                mapGroup.transform({ scale: currentZoom });
            });
        });

    // Add zoom controls
    let currentZoom = 1;
    const zoomStep = 0.2;

    document.querySelector('.zoom-in').addEventListener('click', () => {
        currentZoom += zoomStep;
        const bbox = mapGroup.bbox();
        const centerX = containerWidth / 2;
        const centerY = containerHeight / 2;
        mapGroup.transform({
            translateX: centerX - (bbox.width * currentZoom) / 2,
            translateY: centerY - (bbox.height * currentZoom) / 2,
            scale: currentZoom
        });
    });

    document.querySelector('.zoom-out').addEventListener('click', () => {
        if (currentZoom > zoomStep) {
            currentZoom -= zoomStep;
            const bbox = mapGroup.bbox();
            const centerX = containerWidth / 2;
            const centerY = containerHeight / 2;
            mapGroup.transform({
                translateX: centerX - (bbox.width * currentZoom) / 2,
                translateY: centerY - (bbox.height * currentZoom) / 2,
                scale: currentZoom
            });
        }
    });
}); 