using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public interface IRenderer
    {
        string Render(IRenderable item);
    }
}