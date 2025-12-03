using System.Data.Entity;

namespace ApiCSharp.Models
{
    public class DBAPIEntities : DbContext
    {
        public DBAPIEntities() : base("name=DBAPIEntities")
        {
        }
        public DbSet<INVENT> INVENTs { get; set; }
    }
}