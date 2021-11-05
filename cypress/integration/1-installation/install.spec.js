describe('Installation', () => {
    it('Goto installer and click button to requirements', () => {
        cy.visit('/install')
        cy.get('.button').click()
    })

    it('Goto permissions and check', () => {
        cy.get('.button').click()
    })

    it('Goto configure Environment', () => {
        cy.get('.button').click()
        cy.get('.button-wizard').click()
        cy.get('#app_name').clear().type('Cypress Test')
        cy.get('#environment').select('production')
        cy.get('#app_url').clear().type(Cypress.config().baseUrl)
        cy.get('#mail_driver').clear().type('smtp')
        cy.get('#mail_host').clear().type('173.20.0.4')
        cy.get('#mail_port').clear().type('1025')
        cy.get('#mail_username').clear().type(' ')
        cy.get('#mail_password').clear().type(' ')
        cy.get('#setup_database').click()

        cy.get('#database_connection').select('mysql')
        cy.get('#database_hostname').clear().type('db')
        cy.get('#database_port').clear().type('3306')
        cy.get('#database_name').clear().type('simplehome')
        cy.get('#database_username').clear().type('simplehome')
        cy.get('#database_password').clear().type('simplehome')


        cy.get('#setup_account').click()


        cy.get('#create_account_app_id').clear().type('Firstname')
        cy.get('#create_account_email').clear().type('test@test.com')
        cy.get('#create_account_password').clear().type('simplehome123456')
        cy.get('#create_account_password_confirmation').clear().type('simplehome123456')
        cy.get('#start_install').click()

        cy.get('#error_alert').should('not.exist');

        cy.get('.button').click();


    })
})
