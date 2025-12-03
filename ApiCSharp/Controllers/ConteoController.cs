using ApiCSharp.Models;
using ApiCSharp.Models.ViewModels;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Web.Http;

namespace ApiCSharp.Controllers
{
    [RoutePrefix("api/conteo")]
    public class ConteoController : ApiController
    {
        [HttpGet]
        [Route("")]
        public IHttpActionResult Get()
        {
            try
            {
                List<ConteoViewModel> lst = new List<ConteoViewModel>();

                using (DBAPIEntities db = new DBAPIEntities())
                {
                    lst = (from d in db.INVENTs  
                           select new ConteoViewModel
                           {
                               id = d.ID,
                               Descripcion = d.DESCRIPCION,
                               Cantidad = (int)d.CANTIDAD,
                           }).ToList();
                }

                return Ok(lst);
            }
            catch (System.Exception ex)
            {
                return InternalServerError(ex);
            }
        }

        [HttpGet]
        [Route("{id:int}")]
        public IHttpActionResult GetById(int id)
        {
            try
            {
                using (DBAPIEntities db = new DBAPIEntities())
                {
                    var item = db.INVENTs.Find(id);

                    if (item == null)
                    {
                        return NotFound();
                    }

                    var resultado = new ConteoViewModel
                    {
                        id = item.ID,
                        Descripcion = item.DESCRIPCION,
                        Cantidad = (int)item.CANTIDAD
                    };

                    return Ok(resultado);
                }
            }
            catch (System.Exception ex)
            {
                return InternalServerError(ex);
            }
        }

        [HttpPost]
        [Route("")]
        public IHttpActionResult Add(ConteoRequest model)  
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            try
            {
                using (DBAPIEntities db = new DBAPIEntities())
                {
                    var conteo = new INVENT
                    {
                        DESCRIPCION = model.Descripcion,
                        CANTIDAD = model.Cantidad
                    };

                    db.INVENTs.Add(conteo);
                    db.SaveChanges();

                    return Ok(new
                    {
                        success = true,
                        message = "Registro guardado exitosamente",
                        id = conteo.ID
                    });
                }
            }
            catch (System.Exception ex)
            {
                return InternalServerError(ex);
            }
        }

        [HttpPut]
        [Route("")]
        public IHttpActionResult Edit(ConteoRequestEdit model)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            try
            {
                using (DBAPIEntities db = new DBAPIEntities())
                {
                    var conteo = db.INVENTs.Find(model.IDINV);

                    if (conteo == null)
                    {
                        return NotFound();
                    }

                    conteo.DESCRIPCION = model.Descripcion;
                    conteo.CANTIDAD = model.Cantidad;

                    db.Entry(conteo).State = EntityState.Modified;
                    db.SaveChanges();

                    return Ok(new
                    {
                        success = true,
                        message = "Registro actualizado exitosamente"
                    });
                }
            }
            catch (System.Exception ex)
            {
                return InternalServerError(ex);
            }
        }

        [HttpDelete]
        [Route("{id:int}")]
        public IHttpActionResult Delete(int id)  
        {
            if (id <= 0)
            {
                return BadRequest("ID inválido");
            }

            try
            {
                using (var db = new DBAPIEntities())
                {
                    var item = db.INVENTs.Find(id);

                    if (item == null)
                    {
                        return NotFound();
                    }

                    db.INVENTs.Remove(item);  
                    db.SaveChanges();

                    return Ok(new
                    {
                        success = true,
                        message = "Registro eliminado exitosamente"
                    });
                }
            }
            catch (System.Exception ex)
            {
                return InternalServerError(ex);
            }
        }
    }
}