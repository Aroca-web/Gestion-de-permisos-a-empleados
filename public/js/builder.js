document.addEventListener('DOMContentLoaded', () => {
    const apiBase = '/api/admin';
    let config = {
        roles: [],
        brands: [],
        permissions: [],
        matrix: {}
    };

    // DOM Elements
    const listRoles = document.getElementById('list-roles');
    const listBrands = document.getElementById('list-brands');
    const matrixRoleSelect = document.getElementById('matrix-role');
    const matrixBrandSelect = document.getElementById('matrix-brand');
    const permissionsContainer = document.getElementById('permissions-container');
    const placeholderMsg = document.getElementById('placeholder-msg');
    const currentSelectionSpan = document.getElementById('current-selection');
    const btnSaveMatrix = document.getElementById('btn-save-matrix');

    const newRoleInput = document.getElementById('new-role');
    const btnAddRole = document.getElementById('btn-add-role');
    const newBrandInput = document.getElementById('new-brand');
    const btnAddBrand = document.getElementById('btn-add-brand');

    // 1. Initial Load
    fetchConfig();

    function fetchConfig() {
        fetch(`${apiBase}/config`)
            .then(res => res.json())
            .then(data => {
                config = data;
                renderLists();
                renderSelects();
                renderSummary(); // <-- Update Table
                // If a selection was active, re-apply it? simpler to just reset for now.
            })
            .catch(console.error);
    }

    // 2. Render Functions
    function renderLists() {
        // Roles List
        listRoles.innerHTML = '';
        config.roles.forEach(role => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>${role.name}</span>
                <button class="btn btn-outline-danger btn-sm btn-delete-role" data-slug="${role.slug}">&times;</button>
            `;
            listRoles.appendChild(li);
        });

        // Brands List
        listBrands.innerHTML = '';
        config.brands.forEach(brand => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>${brand.name}</span>
                <button class="btn btn-outline-danger btn-sm btn-delete-brand" data-slug="${brand.slug}">&times;</button>
            `;
            listBrands.appendChild(li);
        });

        // Add listeners
        document.querySelectorAll('.btn-delete-role').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const slug = e.target.dataset.slug;
                if (confirm('¿Eliminar rol? Se borrarán todas sus configuraciones.')) deleteRole(slug);
            });
        });

        document.querySelectorAll('.btn-delete-brand').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const slug = e.target.dataset.slug;
                if (confirm('¿Eliminar marca? Se borrarán todas sus configuraciones.')) deleteBrand(slug);
            });
        });
    }

    function renderSelects() {
        // Keep the first option ("Choose...")
        const rVal = matrixRoleSelect.value;
        const bVal = matrixBrandSelect.value;

        matrixRoleSelect.innerHTML = '<option value="" disabled selected>Elige un rol...</option>';
        config.roles.forEach(role => {
            const opt = document.createElement('option');
            opt.value = role.slug;
            opt.textContent = role.name;
            matrixRoleSelect.appendChild(opt);
        });
        if (rVal) matrixRoleSelect.value = rVal; // Try to restore selection

        matrixBrandSelect.innerHTML = '<option value="" disabled selected>Elige una marca...</option>';
        config.brands.forEach(brand => {
            const opt = document.createElement('option');
            opt.value = brand.slug;
            opt.textContent = brand.name;
            matrixBrandSelect.appendChild(opt);
        });
        if (bVal) matrixBrandSelect.value = bVal;
    }

    // 3. Add Item Logic
    btnAddRole.addEventListener('click', () => {
        const name = newRoleInput.value.trim();
        if (!name) return alert('Escribe un nombre para el rol');

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) return alert('Error de seguridad: No se encontró el token CSRF');

        fetch(`${apiBase}/role`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ name })
        })
            .then(res => {
                if (!res.ok) throw new Error('Error creating role');
                return res.json();
            })
            .then(role => {
                newRoleInput.value = '';
                fetchConfig(); // Refresh all
            })
            .catch(err => alert(err.message));
    });

    btnAddBrand.addEventListener('click', () => {
        const name = newBrandInput.value.trim();
        if (!name) return alert('Escribe un nombre para la marca');

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) return alert('Error de seguridad: No se encontró el token CSRF');

        fetch(`${apiBase}/brand`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ name })
        })
            .then(res => {
                if (!res.ok) throw new Error('Error creating brand');
                return res.json();
            })
            .then(brand => {
                newBrandInput.value = '';
                fetchConfig(); // Refresh all
            })
            .catch(err => alert(err.message));
    });

    // 4. Matrix Logic
    function updateMatrixView() {
        const rSlug = matrixRoleSelect.value;
        const bSlug = matrixBrandSelect.value;

        if (rSlug && bSlug) {
            permissionsContainer.style.display = 'block';
            placeholderMsg.style.display = 'none';
            currentSelectionSpan.textContent = `${rSlug} - ${bSlug}`;

            // Uncheck all first
            document.querySelectorAll('.perm-check').forEach(cb => {
                cb.checked = false;
                if (cb.closest('.permission-item'))
                    cb.closest('.permission-item').classList.remove('active');
            });

            // Check existing permissions
            if (config.matrix[rSlug] && config.matrix[rSlug][bSlug]) {
                const perms = config.matrix[rSlug][bSlug]; // Array of slugs
                perms.forEach(pSlug => {
                    // Find checkbox with value == pSlug
                    const cb = document.querySelector(`.perm-check[value="${pSlug}"]`);
                    if (cb) {
                        cb.checked = true;
                        cb.closest('.permission-item').classList.add('active');
                    }
                });

                // Add change listeners for visual feedback
                document.querySelectorAll('.perm-check').forEach(cb => {
                    cb.addEventListener('change', function () {
                        if (this.checked) {
                            this.closest('.permission-item').classList.add('active');
                        } else {
                            this.closest('.permission-item').classList.remove('active');
                        }
                    });
                });
            }

        } else {
            permissionsContainer.style.display = 'none';
            placeholderMsg.style.display = 'block';
        }
    }

    matrixRoleSelect.addEventListener('change', updateMatrixView);
    matrixBrandSelect.addEventListener('change', updateMatrixView);

    function renderSummary() {
        const tbody = document.querySelector('#summary-table tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        if (!config.matrix || Object.keys(config.matrix).length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No hay configuraciones guardadas</td></tr>';
            return;
        }

        // Iterar matrix: roleSlug -> brandSlug -> [perms]
        for (const [rSlug, brands] of Object.entries(config.matrix)) {
            // Obtener nombre bonito del rol
            const roleObj = config.roles.find(r => r.slug === rSlug);
            const roleName = roleObj ? roleObj.name : rSlug;

            for (const [bSlug, perms] of Object.entries(brands)) {
                if (!perms || perms.length === 0) continue;

                const brandObj = config.brands.find(b => b.slug === bSlug);
                const brandName = brandObj ? brandObj.name : bSlug;

                // Mapear slugs de permisos a nombres
                const permNames = perms.map(pSlug => {
                    const pObj = config.permissions.find(p => p.slug === pSlug);
                    return pObj ? pObj.name : pSlug;
                });

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="fw-bold">${roleName}</td>
                    <td>${brandName}</td>
                    <td>${permNames.join(', ')}</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm btn-delete-config" data-role="${rSlug}" data-brand="${bSlug}">
                           Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            }
        }

        // Add listeners for delete buttons
        document.querySelectorAll('.btn-delete-config').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent form submission if inside a form
                if (confirm('¿Estás seguro de eliminar esta configuración?')) {
                    deleteConfig(this.dataset.role, this.dataset.brand);
                }
            });
        });
    }

    // Include renderSummary in the fetchConfig success chain
    // The original fetchConfig function is replaced here to include renderSummary and updateMatrixView
    fetchConfig = function () {
        fetch(`${apiBase}/config`)
            .then(res => res.json())
            .then(data => {
                config = data;
                renderLists();
                renderSelects();
                renderSummary(); // <-- ADDED
                updateMatrixView(); // Update view if selection exists
            })
            .catch(console.error);
    };
    // Call it immediately
    fetchConfig();

    // 5. Save Matrix
    btnSaveMatrix.addEventListener('click', () => {
        const rSlug = matrixRoleSelect.value;
        const bSlug = matrixBrandSelect.value;
        if (!rSlug || !bSlug) return;

        const selectedPerms = [];
        document.querySelectorAll('.perm-check:checked').forEach(cb => {
            selectedPerms.push(cb.value);
        });

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) return alert('Error de seguridad: No se encontró el token CSRF');

        fetch(`${apiBase}/matrix`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                role_slug: rSlug,
                brand_slug: bSlug,
                permissions: selectedPerms
            })
        })
            .then(res => {
                if (!res.ok) throw new Error('Error al guardar. Verifica la consola.');
                return res.json();
            })
            .then(data => {
                alert('Configuración guardada correctamente');
                fetchConfig(); // Updates local config matrix AND summary
            })
            .catch(err => {
                console.error(err);
                alert('Ocurrió un error al guardar: ' + err.message);
            });
    });

    // 6. Delete Configuration Logic
    function deleteConfig(roleSlug, brandSlug) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) return alert('Error de seguridad: No se encontró el token CSRF');

        fetch(`${apiBase}/matrix/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                role_slug: roleSlug,
                brand_slug: brandSlug
            })
        })
            .then(res => {
                if (!res.ok) throw new Error('Error eliminando configuración');
                return res.json();
            })
            .then(data => {
                alert('Configuración eliminada correctamente');
                fetchConfig(); // Refresh lists
            })
            .catch(err => alert(err.message));
    }


    function deleteRole(slug) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`${apiBase}/role/delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ slug })
        })
            .then(res => res.json())
            .then(() => { fetchConfig(); })
            .catch(console.error);
    }

    function deleteBrand(slug) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`${apiBase}/brand/delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ slug })
        })
            .then(res => res.json())
            .then(() => { fetchConfig(); })
            .catch(console.error);
    }

});
