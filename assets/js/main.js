(($) => {

    /**
     * 3rd party endpoint URL.
     */
    const END_POINT = 'https://jsonplaceholder.typicode.com/users/';

    /**
     * Handles the click event on the table data's anchor tag.
     */
    $('#remote-users').on('click', 'tbody th>a, tbody td>a', ( e ) => {

        e.preventDefault();
        const userID = $(e.target).closest('tr').prop('id');

        /**
         * Fetches data from the 3rd party API.
         */
        $.getJSON( END_POINT + userID, data => {

            let dynamicHTML = 
            `<div>
                <address>
                    <div>Street: <span>${data.address.street}</span></div>
                    <div>City: <span>${data.address.city}</span></div>
                    <a href="mailto:${data.email}">${data.email}</a>
                </address>
            </div>`;
            $(dynamicHTML).dialog({ modal:true, width:600 });
        }).fail( () => {

            console.warn('Error during fetching data');
        });
    });
})(jQuery);