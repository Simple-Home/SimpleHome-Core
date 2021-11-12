describe('User login', () => {

    it('user does not exist', () => {
        cy.visit('/login')

        cy.get('#email').clear().type('test@test.com')
        cy.get('#password').clear().type('admin123456')

        cy.get('form.form-signin').submit()


        cy.get('.invalid-feedback').should('exist')
    })


    it('check login works', () => {
        cy.visit('/login')

        cy.get('#email').clear().type('admin@simplehome.com')
        cy.get('#password').clear().type('admin123456')

        cy.get('form.form-signin').submit()
        cy.get('.invalid-feedback').should('not.exist')
        cy.url().should('not.include', '/email/verify')
    })


})
